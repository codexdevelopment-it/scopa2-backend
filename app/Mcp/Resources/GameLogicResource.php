<?php

namespace App\Mcp\Resources;

use Illuminate\Support\Facades\Schema;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Resource;

class GameLogicResource extends Resource
{
    // The URI the AI will use to "read" this resource
    protected string $uri = 'scopa://logic/core';

    protected string $name = 'scopa-core-logic';
    protected string $description = 'Contains the database schema and core PHP logic (Engine & State) for the Scopa game.';

    public function handle(Request $request): Response
    {
        // 1. Get DB Schema for context
        $dbSchema = [];
        foreach (['games', 'game_events'] as $table) {
            $dbSchema[$table] = Schema::getColumnListing($table);
        }

        // 2. Read Core PHP Files
        // Adjust paths if your Engine is in a different spot
        $engineCode = file_get_contents(app_path('GameEngine/ScopaEngine.php'));
        $stateCode = file_get_contents(app_path('GameEngine/GameState.php'));
        $constants = file_get_contents(app_path('GameEngine/GameConstants.php'));

        $fullContext = "DATABASE SCHEMA:\n" . json_encode($dbSchema, JSON_PRETTY_PRINT) .
            "\n\n--- GameConstants.php ---\n" . $constants .
            "\n\n--- GameState.php ---\n" . $stateCode .
            "\n\n--- ScopaEngine.php ---\n" . $engineCode;

        return Response::text($fullContext);
    }
}
