<?php
namespace BreweryDB;

/**
 * A set of generic tools methods
 *
 * @author Piotr Bernad <bernad.p4@gmail.com>
 */
class Utilities
{
    /**
     * Just print a line
     *
     * @param string $msg
     */
    public static function println(string $msg)
    {
        print sprintf('%s%s',
            $msg,
            PHP_EOL
        );
    }

    /**
     * Log data into a file
     *
     * @param string $text
     * @param string $filename
     */
    public static function logIntoFile(string $text, string $filename)
    {
        self::println('Generating a file with a list...');
        if (!file_exists(LIST_DIR)) {
            if (!mkdir(LIST_DIR, 0755)) {
                throw new \Exception('Failed to create ' . REPORT_DIR);
            }
        }
        file_put_contents(LIST_DIR . '/' . $filename, $text . PHP_EOL);

        self::println('Successfully!!!');
    }
}