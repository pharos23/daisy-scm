<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class DeployController extends Controller
{
    public function deploy(Request $request)
    {
        // only allow admins
        $this->authorize('deploy-app');

        $baseDir = base_path();

        try {
            // Pull latest code
            $this->runCommand(['git', 'pull'], $baseDir);

            // Install npm deps
            $this->runCommand(['npm', 'install'], $baseDir);

            // Build assets
            $this->runCommand(['npm', 'run', 'build'], $baseDir);

            // Artisan commands
            $this->runCommand(['php', 'artisan', 'migrate', '--force'], $baseDir);
            $this->runCommand(['php', 'artisan', 'config:cache'], $baseDir);
            $this->runCommand(['php', 'artisan', 'route:cache'], $baseDir);
            $this->runCommand(['php', 'artisan', 'view:cache'], $baseDir);

            return back()->with('status', 'Deployment complete.');

        } catch (ProcessFailedException $e) {
            return back()->with('error', 'Deployment failed: ' . $e->getMessage());
        }
    }

    protected function runCommand(array $command, string $workingDirectory)
    {
        $process = new Process($command, $workingDirectory);
        $process->setTimeout(300); // allow long build time
        $process->run();

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        return $process->getOutput();
    }
}
