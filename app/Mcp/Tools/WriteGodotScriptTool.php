<?php

namespace App\Mcp\Tools;

use Illuminate\Contracts\JsonSchema\JsonSchema;
use Illuminate\Support\Facades\File;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Tool;

class WriteGodotScriptTool extends Tool
{
    protected string $name = 'write_godot_script';
    protected string $description = 'Creates or overwrites a GDScript file in the Godot project folder.';

    // 2. IMPORTANTE: Devi specificare il tipo (JsonSchema $schema)
    public function schema(JsonSchema $schema): array
    {
        return [
            'filepath' => $schema->string()
                ->description('Relative path inside the Godot project (e.g., "scripts/ShopUI.gd")')
                ->required(),

            'content' => $schema->string()
                ->description('The full GDScript source code')
                ->required(),
        ];
    }

    public function handle(Request $request): Response
    {
        $validated = $request->validate([
            'filepath' => 'required|string',
            'content' => 'required|string',
        ]);

        // Assicurati che questo path punti alla cartella corretta del tuo progetto Godot
        $godotRoot = base_path('../scopa2-game'); // O il nome della tua cartella Godot
        $targetFile = $godotRoot . '/' . $validated['filepath'];

        // Security check semplice
        // Nota: in locale potresti volerlo commentare se ti da problemi di path
        if (!str_starts_with(realpath(dirname($targetFile)) ?: '', realpath($godotRoot) ?: '')) {
            // Logica di sicurezza opzionale
        }

        File::ensureDirectoryExists(dirname($targetFile));
        File::put($targetFile, $validated['content']);

        return Response::text("✅ Successfully wrote file: " . $validated['filepath']);
    }
}
