<?php

namespace Tinkers\PdfOCR;

use Symfony\Components\Process\Process;
use mfony\Component\Process\Exception\ProcessFailedException;

class PdfImages
{
    /**
     *  @var $filepath String pdf file path
     */
    private $_filepath;
    
    /**
     * @var $permited Array list of permitted mime type
     */
    protected $permited = ['application/pdf', 'application/x-pdf'];
    
    private $_options;
    
    public function __construct ($filepath = null)
    {
        if (!empty($filepath)) {
            $this->setFilepath($filepath);
        }
        
        if (!empty($filepath) && !$this->isPDF($filepath)) {
            throw new Exception ('File not found!');
        }
        
    }    
       
    public function setFilepath ($filepath)
    {
        $this->_filepath = $filepath;
    }
    
    public function setOptions ($options = [])
    {
        $this->_options = $options;
    }
    
    protected function isPDF ($filepath)
    {
        
        if (!in_array(mime_content_type($filepath), $this->permited)) {
            throw new Exception ('File type is not permitted');
        }
        
        return is_writable($filepath);
    }
     
    public function extractImages ($extractTo = null, $jpeg = true)
    {
        $process = new Process('ls -lsa');
        
        $process->run();
        
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }
        
        echo $process->getOutput();
    }
    
}