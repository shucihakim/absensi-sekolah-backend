<?php

namespace App\Traits;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

// By: Wildan M Zaki, visit: https://github.com/WildanMZaki
// At: Mar 20, 2024

trait WzCommand
{
    protected
        $ansiColors = [
            'reset' => "\033[0m",
            'white' => "\033[97m",
            'red' => "\033[31m",
            'green' => "\033[32m",
            'yellow' => "\033[33m",
            'blue' => "\033[34m",
            'bg_red' => "\033[41m",
            'bg_green' => "\033[42m",
            'bg_yellow' => "\033[43m",
            'bg_blue' => "\033[44m",
            'bg_white' => "\033[47m",
        ];

    public function verifyUsingMysql(?callable $cbError = null)
    {
        $con = config('database.default');
        $message = 'This command only valid with database mysql connection';
        if ($con != 'mysql') {
            if ($cbError != null) {
                $cbError($message);
            } else {
                $this->danger($message);
            }
            $this->ln();
            exit(0);
        }
    }

    public function fileExists(string $filePath, $error = null)
    {
        if (File::exists($filePath)) {
            return true;
        } else {
            if ($error) {
                $error = is_bool($error) ? "File '$filePath' not found" : $error;
                $this->danger($error);
                exit(0);
            }
            return false;
        }
    }

    public function importSqlFile($sqlFile, $startAt = null)
    {
        $sql = File::get($sqlFile);

        try {
            DB::unprepared($sql);
            $finishAt = time();
            $suffix = $startAt != null ? $this->label($finishAt - $startAt . 's', 'blue') : '';
            $this->inform(basename($sqlFile) . ' imported successfully ' . $suffix);
        } catch (\Exception $e) {
            $this->danger('Fail importing ' . basename($sqlFile) . ', reason: ' . $e->getMessage());
            // exit(1);
        }
    }

    public function ln()
    {
        echo PHP_EOL;
    }

    public function end()
    {
        $this->ln();
        exit(0);
    }

    public function asking($question = 'Am i handsome?', $default = null)
    {
        $this->ln();
        $q = $question . ($default ? " [$default]" : '');
        $this->say($q, $this->ansiColors['green']);
        echo ">";
        $answer = $default;
        $answer = trim(fgets(STDIN));
        if (!$answer && !$default) {
            $this->warn("Operation canceled!");
            exit(1);
        }
        $this->ln();
        return $answer;
    }

    public function label($txt, $c = 'red')
    {
        return $this->ansiColors["bg_$c"] . " $txt " . $this->ansiColors['reset'];
    }

    public function inform($message = "Information", $bgColored = true)
    {
        $color = $bgColored ? '' : $this->ansiColors['blue'];
        $message = !$bgColored ? "Info: $message" : ($this->label('Info:', 'blue') . " $message");
        $this->say($message, $color);
    }

    public function warning($message = "Warning", $bgColored = true)
    {
        $color = $bgColored ? '' : $this->ansiColors['yellow'];
        $message = !$bgColored ? "Warning: $message" : ($this->label('Warning:', 'yellow') . " $message");
        $this->say($message, $color);
    }

    public function success($message = "Success", $bgColored = true)
    {
        $color = $bgColored ? '' : $this->ansiColors['green'];
        $message = !$bgColored ? "Success: $message" : ($this->label('Success:', 'green') . " $message");
        $this->say($message, $color);
    }

    public function danger($message = "Some Error happened", $bgColored = true)
    {
        $color = $bgColored ? '' : $this->ansiColors['red'];
        $message = !$bgColored ? "Error: $message" : ($this->label('Error:') . " $message");
        $this->say($message, $color);
    }

    public function say($message, $color)
    {
        echo $color . $message . $this->ansiColors['reset'] . PHP_EOL;
    }
}
