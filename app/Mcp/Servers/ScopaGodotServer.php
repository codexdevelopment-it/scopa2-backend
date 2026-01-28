<?php

namespace App\Mcp\Servers;

use App\Mcp\Resources\GameLogicResource;
use App\Mcp\Tools\WriteGodotScriptTool;
use Laravel\Mcp\Server;

class ScopaGodotServer extends Server
{
    protected string $name = 'Scopa Godot Bridge';
    protected string $version = '1.0.0';
    protected string $instructions = 'You are a Godot Developer Assistant. Use the game logic resource to understand the backend, then use the write tool to create UI scripts.';

    protected array $tools = [
        WriteGodotScriptTool::class,
    ];

    protected array $resources = [
        GameLogicResource::class,
    ];

    protected array $prompts = [];
}
