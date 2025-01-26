<?php
//set the namespace
namespace BytesPhp\Rest\Server\Types\Extension;

//add namespace(s) required from 'BYTES.PHP' framework
use BytesPhp\Reflection\ClassMetadata as ClassMetadata;

//add internal namespace(s) required
use BytesPhp\Rest\Server\Types\Context\ApplicationContext as ApplicationContext;

//the extension (base) class
class Extension{

    //protected properties
    protected ApplicationContext $appContext;
    protected ClassMetadata $metadata;

    //initializes the extension (instance)
    function initialize(ApplicationContext $context, ClassMetadata $metadata): void{

        $this->appContext = $context;
        $this->metadata = $metadata;

    }
    
}
?>