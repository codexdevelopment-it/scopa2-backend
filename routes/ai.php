<?php

use App\Mcp\Servers\ScopaGodotServer;
use Laravel\Mcp\Facades\Mcp;

Mcp::local('scopa', ScopaGodotServer::class);
