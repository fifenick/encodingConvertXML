<?php
/**
 * functions to convert the encoding in an xml file
 * @version 0.1
 */

class convert {

    /**
     * constructer function
     */
    public function __construct() {
        
    }

    /**
     * get the content forma file
     * @param type $filePath
     * @return type
     */
    private function getFileContent($filePath) {
        return trim(file_get_contents($filePath));
    }

    /**
     * save content to a file
     * @param type $filename
     * @param type $content
     */
    private function setFileContent($filename, $content) {
        file_put_contents($filename, "\xEF\xBB\xBF" . $content);
    }

    /**
     * convert encoding
     * @param type $filePath
     * @param type $to_encoding
     * @throws UnexpectedValueException
     */
    function convert($filePath, $to_encoding) {
        $filein = 'input/' . $filePath;
        $content = '';
        $contents = file($filein);
        $i = 0;

        foreach ($contents as $line) {
            $encoding = mb_detect_encoding($line);
            if ( FALSE === $encoding ) {
                throw new UnexpectedValueException(
                sprintf(
                        'Unable to detect input encoding with mb_detect_encoding, order was: %s'
                        , print_r($order, true)
                )
                );
            }
            $coding = $to_encoding . '//IGNORE';
            if ( $i !== 0 ) {

                $content .= iconv($encoding, $coding, $line);
                echo mb_check_encoding($content, $to_encoding);
            } else {
                  
                $content .= iconv($encoding, $coding, '<?xml version="1.0" encoding="UTF-8"?>');
            }
            $i++;
        }
        $fileout = 'output/' . $filePath;
        $this->setFileContent($fileout, $content);
    }

}
