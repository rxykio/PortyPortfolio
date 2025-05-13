<?php
require_once 'app/controllers/ProjectController.php';

$uri = $_GET['url'] ?? 'landing';
$uri = rtrim($uri, '/');
$uri = urldecode($uri);
$uri = trim($uri);


$controller = new ProjectController();

switch ($uri) {
        case '':
    case 'landing':
        require 'landing.php';
        break;
         case 'test':
        require 'test.php';
        break;
        case 'admin':
            $controller->admin();
            break;
            case 'profile':
                $controller->profile();
                break;
                case 'saveProfile':
                    $controller->saveProfile();
                    break;
    case 'create':
        $controller->create();
        break;
    case 'store':
        $controller->store();
        break;
    case 'edit':
        $controller->edit($_GET['id']);
        break;
    case 'update':
        $controller->update($_GET['id']);
        break;
    case 'delete':
        $controller->delete($_GET['id']);
        break;
    default:
        $controller->publicPortfolio($uri);
        break;
}
