<?php

namespace GestionPfeBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class GestionPfeBundle extends Bundle
{
    public function getParent(){
        return 'FOSUserBundle';
    }




}
