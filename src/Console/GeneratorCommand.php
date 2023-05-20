<?php

declare(strict_types=1);

namespace Yodaka\LaravelRequestIdeHelper\Console;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputArgument;
use Yodaka\LaravelRequestIdeHelper\FileWriter;
use Yodaka\LaravelRequestIdeHelper\Parser;

class GeneratorCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'request-ide-helper:generate --{className}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate PHPDoc for Laravel Request class.';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $className = $this->argument('className');
        $className = 'App\Http\Requests\\' . $className;
        $this->info("Generating PHPDoc for {$className}...");
        $request = new $className();
        $rules = Parser::generatePhpDoc($request->rules());
        $path = (new \ReflectionClass(get_class($request)))->getFileName();
        FileWriter::write($path, $rules);
        $this->info("Done!");
    }

    public function getArguments()
    {
        return [
            ['className', InputArgument::REQUIRED, 'The name of the class.'],
        ];
    }
}
