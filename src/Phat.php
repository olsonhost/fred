<?php

namespace Olsonhost\Phat;

class Phat
{

    public $vars = [];

    public function __construct()
    {


    }

    public function view($output, $data = []) {

        // Copy this to the vendor package source and push to github to update (I think)

        // $this->page = $this->view($this->output, $this->data);

        /*
         *     public function view($output, $data = []) {

                    $phat = new Phat;

                    $output = $phat->view($output, $data);

         */

        // $output is the final page and $data is the json array which defines the page and may contain phat vars for us

        // $data may also be augmented with additional variables during prior page processing like i don't know what right now

        $output = $this->prep($output, $data); // process strings, constants and variables

        $output = $this->exec($output, $data); // execute @functions

        return $output;
    }

    // example <h1><img src="@asset('images/nl.jpg')"><span style="margin-left:-90px;">Blackrush Entertainment</span></h1>

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

        // TODO: handle litereals, vars, etc.  Right now just assuming a quoted string and that's all
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
            default:
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
