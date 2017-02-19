<?php
/**
 * @copyright Ilch 2.0
 * @package ilch
 */

namespace Modules\Admin\Plugins;

use Modules\Admin\Mappers\Page as PageMapper;
use Modules\Admin\Mappers\Logs as LogsMapper;

class AfterDatabaseLoad
{
    public function __construct(array $pluginData)
    {
        $request = $pluginData['request'];
        $router = $pluginData['router'];

        $pageMapper = new PageMapper();
        $permas = $pageMapper->getPagePermas();
        $url = $router->getQuery();

        if (isset($permas[$url])) {
            $request->setModuleName('admin');
            $request->setControllerName('page');
            $request->setActionName('show');
            $request->setParam('id', $permas[$url]['page_id']);
            $request->setParam('locale', $permas[$url]['locale']);
        }

        // Log the entrys
        $logsMapper = new LogsMapper();
        $currentUrl = $_SERVER['REQUEST_URI'];

        if (strpos($currentUrl, '/admin/') == true AND !empty($_SESSION['user_id'])) {
            $userId = (int) $_SESSION['user_id'];

            $logsMapper->saveLog($userId, $currentUrl);
        }
    }
}
