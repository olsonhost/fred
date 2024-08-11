<?php
/*

 ▄▄▄▄    ██▓    ▄▄▄       ▄████▄   ██ ▄█▀ ██▀███   █    ██   ██████  ██░ ██
▓█████▄ ▓██▒   ▒████▄    ▒██▀ ▀█   ██▄█▒ ▓██ ▒ ██▒ ██  ▓██▒▒██    ▒ ▓██░ ██▒
▒██▒ ▄██▒██░   ▒██  ▀█▄  ▒▓█    ▄ ▓███▄░ ▓██ ░▄█ ▒▓██  ▒██░░ ▓██▄   ▒██▀▀██░
▒██░█▀  ▒██░   ░██▄▄▄▄██ ▒▓▓▄ ▄██▒▓██ █▄ ▒██▀▀█▄  ▓▓█  ░██░  ▒   ██▒░▓█ ░██
░▓█  ▀█▓░██████▒▓█   ▓██▒▒ ▓███▀ ░▒██▒ █▄░██▓ ▒██▒▒▒█████▓ ▒██████▒▒░▓█▒░██▓
░▒▓███▀▒░ ▒░▓  ░▒▒   ▓▒█░░ ░▒ ▒  ░▒ ▒▒ ▓▒░ ▒▓ ░▒▓░░▒▓▒ ▒ ▒ ▒ ▒▓▒ ▒ ░ ▒ ░░▒░▒
▒░▒   ░ ░ ░ ▒  ░ ▒   ▒▒ ░  ░  ▒   ░ ░▒ ▒░  ░▒ ░ ▒░░░▒░ ░ ░ ░ ░▒  ░ ░ ▒ ░▒░ ░
 ░    ░   ░ ░    ░   ▒   ░        ░ ░░ ░   ░░   ░  ░░░ ░ ░ ░  ░  ░   ░  ░░ ░
 ░          ░  ░     ░  ░░ ░      ░  ░      ░        ░           ░   ░  ░  ░
      ░                  ░



*/

namespace Olsonhost\Phat;

class Phat
{

    protected $vars = [];

    protected $includes = [];

    protected $modules;

    const BLACKRUSH = "
 ▄▄▄▄    ██▓    ▄▄▄       ▄████▄   ██ ▄█▀ ██▀███   █    ██   ██████  ██░ ██
▓█████▄ ▓██▒   ▒████▄    ▒██▀ ▀█   ██▄█▒ ▓██ ▒ ██▒ ██  ▓██▒▒██    ▒ ▓██░ ██▒
▒██▒ ▄██▒██░   ▒██  ▀█▄  ▒▓█    ▄ ▓███▄░ ▓██ ░▄█ ▒▓██  ▒██░░ ▓██▄   ▒██▀▀██░
▒██░█▀  ▒██░   ░██▄▄▄▄██ ▒▓▓▄ ▄██▒▓██ █▄ ▒██▀▀█▄  ▓▓█  ░██░  ▒   ██▒░▓█ ░██
░▓█  ▀█▓░██████▒▓█   ▓██▒▒ ▓███▀ ░▒██▒ █▄░██▓ ▒██▒▒▒█████▓ ▒██████▒▒░▓█▒░██▓
░▒▓███▀▒░ ▒░▓  ░▒▒   ▓▒█░░ ░▒ ▒  ░▒ ▒▒ ▓▒░ ▒▓ ░▒▓░░▒▓▒ ▒ ▒ ▒ ▒▓▒ ▒ ░ ▒ ░░▒░▒
▒░▒   ░ ░ ░ ▒  ░ ▒   ▒▒ ░  ░  ▒   ░ ░▒ ▒░  ░▒ ░ ▒░░░▒░ ░ ░ ░ ░▒  ░ ░ ▒ ░▒░ ░
 ░    ░   ░ ░    ░   ▒   ░        ░ ░░ ░   ░░   ░  ░░░ ░ ░ ░  ░  ░   ░  ░░ ░
 ░          ░  ░     ░  ░░ ░      ░  ░      ░        ░           ░   ░  ░  ░
      ░                  ░
";

    public function __construct()
    {


    }

    public function view($output, $data = [], $modules = false) {

        $this->modules = $modules; // Modules may contain Phat extensions that we will look for

        $output = $this->prep($output, $data); // process strings, constants and variables

        $output = $this->exec($output, $data); // execute @functions

        return $output;
    }

    function prep($output, $data) {
        // step 1, replace all @aphatwelve( with chr(1) + APHATWELVE
        // Find all possible @functions and replace them with ¢FUNCTIONS

        $continue = true;

        do {

            $strung = $this->getSubstringBetweenSpecialChars($output, '@', '(');

            if (!$strung) {
                $continue = false;
                break;
            }

            if ($this->isAlphaStringLessThan12($strung)) {

                $output = str_replace('@' . $strung . '(', '¢' . strtoupper($strung) . '(', $output);

            } else {

                $output = str_replace('@' . $strung . '(', '£¥' . $strung . '(', $output);

            }

        } while($continue);

        // Step 2, Lets insert any #variables we may have defined

        foreach ($this->vars as $var => $val) {
            $output = str_replace('#' . $var, $val, $output);
        }


        return str_replace('£¥', '@', $output);
    }

    function exec($output, $data) {

        // original - hello @say('world') yay

        $split = explode('¢', $output,2); // hello ] ¢ [SAY('world') yay

        $left = $split[0]; // hello ]

        $right = $split[1] ?? false; // [SAY('world') yay

        if ($right) {
            $right = $this->exec($right, $data); // [SAY('world') yay
        } else {
            return $output; // nothing left to do
        }

        $fun = explode(')', $right,2);

        $right = $fun[1];

        $command = $fun[0]; // string(21) "ASSET('images/nl.jpg'"

        $expr = explode('(', $command );

        $head = $expr[0];

        $tail = $expr[1];

        // TODO: handle literals, vars, etc.  Right now just assuming a quoted string and that's all
        $tail = str_replace(['"', "'"], '', $tail); // just remove quotes

        switch($head) {
            case 'ASSET':
                $command = '/themes/blackrush/' . $tail;
                break;
            case 'BODY':
                $command = $data->body;
                break;
            case 'EXAMPLE':
                $command = $data->example_phat_var;
                break;
            case 'DATA':
                //$command = $data[$tail]; // ??
                $command = 'TODO data var ' . $tail;
                break;
            case 'EDIT':
                $command = "<button class='phat-edit btn btn-success btn-sm' rel='$tail'>Edit</button>";
                break;
            case 'BLACKRUSH':
                $command = "<pre style='font-size:50%;'>" . Self::BLACKRUSH . "</pre>";
                break;
            default:

                // SO.. we need to see if any $module classes have a Phat function
                // or an array?  An array of functions??
                $command = '';
                foreach ($this->modules as $module) {
                    // Check if the phat_ method exists in the module
                    if (method_exists($module, 'phat_' . $head)) {
                        // Call the method and pass $tail as the argument
                        $command .= $module->$head($tail);
                        // If more than 1 module has a Phat function then we're going to call them all!
                    }
                }

                $command = '?' . $head . '?';
        }



        $output = $left . $command . $right;

        return $output;
    }


    function getSubstringBetweenSpecialChars($string, $char1, $char2) { // thanks ChatGPT!
        $start = strpos($string, $char1);
        if ($start === false) {
            return false;
        }

        $end = strpos($string, $char2, $start + 1);
        if ($end === false) {
            return false;
        }

        $length = $end - $start - 1;

        return substr($string, $start + 1, $length);
    }

    function isAlphaStringLessThan12($string) {
        $pattern = '/^[a-zA-Z]+$/';

        if (strlen($string) <= 12 && preg_match($pattern, $string)) { // thanks ChatGPT!
            return true;
        } else {
            return false;
        }
    }

}
