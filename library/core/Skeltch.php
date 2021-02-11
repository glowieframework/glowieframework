<?php
    namespace Glowie;

    /**
     * PHP preprocessor for Glowie application.
     * @category PHP preprocessor
     * @package glowie
     * @author Glowie
     * @copyright Copyright (c) 2021
     * @license MIT
     * @link https://glowie.tk
     * @version 0.2-alpha
     */
    class Skeltch{

        /**
         * Compiles a Skeltch view to a temporary location.
         * @param string $filename Skeltch view to read and compile.
         * @return string Returns the compiled file full location.
         */
        public static function compile(string $filename){
            // Checks for file and temp folder
            if(!is_readable($filename)) trigger_error('Skeltch: File "' . $filename . '" is not readable');
            $tmpdir = sys_get_temp_dir();
            if(!\Util::endsWith($tmpdir, '/')) $tmpdir = $tmpdir . '/';
            if(!is_writable($tmpdir)) trigger_error('Skeltch: PHP temp directory is not writable, please check your settings');
            
            // Read and compile the file
            $code = file_get_contents($filename);
            $code = self::compileEchos($code);
            $code = self::compileLoops($code);
            $code = self::compileIfs($code);
            $code = self::compileRenders($code);
            $code = self::compilePHP($code);
            $code = self::compileComments($code);

            // Write compiled code to temp file
            $tmpfile = tempnam($tmpdir, 'sk_');
            $handle = fopen($tmpfile, "w");
            fwrite($handle, $code);
            fclose($handle);

            // Returns the temp file location
            return $tmpfile;
        }

        /**
         * Compiles conditional statements.
         * @param string $code Code to compile.
         * @return string Returns the compiled code.
         */
        private static function compileIfs(string $code){
            $code = preg_replace('~{\s*@if\s*\((.+?)\)\s*}~is', '<?php if($1): ?>', $code);
            $code = preg_replace('~{\s*@isset\s*\((.+?)\)\s*}~is', '<?php if(isset($1)): ?>', $code);
            $code = preg_replace('~{\s*@empty\s*\((.+?)\)\s*}~is', '<?php if(empty($1)): ?>', $code);
            $code = preg_replace('~{\s*@notempty\s*\((.+?)\)\s*}~is', '<?php if(!empty($1)): ?>', $code);
            $code = preg_replace('~{\s*@elseif\s*\((.+?)\)\s*}~is', '<?php elseif($1): ?>', $code);
            $code = preg_replace('~{\s*@else\s*}~is', '<?php else: ?>', $code);
            $code = preg_replace('~{\s*(@endif|@endisset|@endempty)\s*}~is', '<?php endif; ?>', $code);
            return $code;
        }

        /**
         * Compiles render statements.
         * @param string $code Code to compile.
         * @return string Returns the compiled code.
         */
        private static function compileRenders(string $code){
            $code = preg_replace('~{\s*@view\s*\((.+?)\)\s*}~is', '<?php $this->renderView($1); ?>', $code);
            $code = preg_replace('~{\s*@template\s*\((.+?)\)\s*}~is', '<?php $this->renderTemplate($1); ?>', $code);
            return $code;
        }

        /**
         * Compiles raw PHP statements.
         * @param string $code Code to compile.
         * @return string Returns the compiled code.
         */
        private static function compilePHP(string $code){
		    return preg_replace('~{\s*%\s*(.+?)\s*}~is', '<?php $1 ?>', $code);
	    }

        /**
         * Compiles loop statements.
         * @param string $code Code to compile.
         * @return string Returns the compiled code.
         */
        private static function compileLoops(string $code){
            $code = preg_replace('~{\s*@foreach\s*\((.+?)\)\s*}~is', '<?php foreach($1): ?>', $code);
            $code = preg_replace('~{\s*@for\s*\((.+?)\)\s*}~is', '<?php for($1): ?>', $code);
            $code = preg_replace('~{\s*@endforeach\s*}~is', '<?php endforeach; ?>', $code);
            $code = preg_replace('~{\s*@endfor\s*}~is', '<?php endfor; ?>', $code);
            $code = preg_replace('~{\s*@break\s*}~is', '<?php break; ?>', $code);
            $code = preg_replace('~{\s*@continue\s*}~is', '<?php continue; ?>', $code);
            return $code;
        }

        /**
         * Compiles echo statements.
         * @param string $code Code to compile.
         * @return string Returns the compiled code.
         */
        private static function compileEchos(string $code){
            $code = preg_replace('~{{\s*!!\s*(.+?)\s*}}~is', '<?php echo $1; ?>', $code);
            $code = preg_replace('~{{\s*(.+?)\s*}}~is', '<?php echo htmlspecialchars($1); ?>', $code);
            return $code;
        }

        /**
         * Compile comments.
         * @param string $code Code to compile.
         * @return string Returns the compiled code.
         */
        private static function compileComments(string $code){
            return preg_replace('~{\s*#\s*(.+?)\s*}~is', '<?php // $1 ?>', $code);
        }

    }
?>