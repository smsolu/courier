<?php

namespace AppBundle\Controller\Start;

use ABMBundle\Services\AbmManager;
use AppBundle\Exception\CheckPermissionsException;
use AppBundle\Exception\DeleteException;
use AppBundle\Exception\ListException;
use AppBundle\Exception\NewException;
use AppBundle\Exception\UndoDeleteException;
use AppBundle\Exception\ValidateException;
use AppBundle\Form\Type\Expediente\ExpedienteFindType;
use Exception;
use ListViewBundle\Services\LinkColumn;
use ListViewBundle\Services\ListView;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;


    /**
     * @Route("/start")
     */
class StartUserController extends Controller
{
    /**
     * @Route("/user/", name="start_user")
     * @Template()
     */
    public function startUserAction(Request $request)
    {

        $user = $this->getUser();
        return array('user' => $user);
        
    }
    
}
    