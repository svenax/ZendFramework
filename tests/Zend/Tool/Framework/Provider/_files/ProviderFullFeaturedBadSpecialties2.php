<?php

require_once 'Zend/Tool/Framework/Provider/Abstract.php';

class Zend_Tool_Framework_Provider_ProviderFullFeaturedBadSpecialties2 extends Zend_Tool_Framework_Provider_Abstract
{
    
    
    
    public function getSpecialties()
    {
        return new ArrayObject(array('Hi', 'BloodyMurder', 'ForYourTeam'));
    }
    
    
    
}

