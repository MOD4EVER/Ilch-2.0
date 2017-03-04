<?php
/**
 * @copyright Ilch 2.0
 * @package ilch
 */

namespace Modules\War\Controllers\Admin;

use Ilch\Validation;

class Settings extends \Ilch\Controller\Admin
{
    public function init()
    {
        $items = [
            [
                'name' => 'menuWars',
                'active' => false,
                'icon' => 'fa fa-shield',
                'url' => $this->getLayout()->getUrl(['controller' => 'index', 'action' => 'index'])
            ],
            [
                'name' => 'menuEnemy',
                'active' => false,
                'icon' => 'fa fa-th-list',
                'url' => $this->getLayout()->getUrl(['controller' => 'enemy', 'action' => 'index'])
            ],
            [
                'name' => 'menuGroups',
                'active' => false,
                'icon' => 'fa fa-th-list',
                'url' => $this->getLayout()->getUrl(['controller' => 'group', 'action' => 'index'])
            ],
            [
                'name' => 'menuSettings',
                'active' => true,
                'icon' => 'fa fa-th-list',
                'url' => $this->getLayout()->getUrl(['controller' => 'settings', 'action' => 'index'])
            ]
        ];

        $this->getLayout()->addMenu
        (
            'menuWars',
            $items
        );
    }

    public function indexAction()
    {
        $this->getLayout()->getAdminHmenu()
                ->add($this->getTranslator()->trans('manageWarOverview'), ['action' => 'index'])
                ->add($this->getTranslator()->trans('settings'), ['action' => 'index']);

        $post = [
            'warsPerPage' => '',
            'enemiesPerPage' => '',
            'groupsPerPage' => '',
            'boxNextWarLimit' => '',
            'boxLastWarLimit' => ''
        ];

        if ($this->getRequest()->isPost()) {
            $post = [
                'warsPerPage' => $this->getRequest()->getPost('warsPerPage'),
                'enemiesPerPage' => $this->getRequest()->getPost('enemiesPerPage'),
                'groupsPerPage' => $this->getRequest()->getPost('groupsPerPage'),
                'boxNextWarLimit' => $this->getRequest()->getPost('boxNextWarLimit'),
                'boxLastWarLimit' => $this->getRequest()->getPost('boxLastWarLimit')
            ];

            $validation = Validation::create($post, [
                'warsPerPage' => 'numeric|integer|min:1',
                'enemiesPerPage' => 'numeric|integer|min:1',
                'groupsPerPage' => 'numeric|integer|min:1',
                'boxNextWarLimit' => 'numeric|integer|min:1',
                'boxLastWarLimit' => 'numeric|integer|min:1'
            ]);

            if ($validation->isValid()) {
                $this->getConfig()->set('war_warsPerPage', $post['warsPerPage']);
                $this->getConfig()->set('war_enemiesPerPage', $post['enemiesPerPage']);
                $this->getConfig()->set('war_groupsPerPage', $post['groupsPerPage']);
                $this->getConfig()->set('war_boxNextWarLimit', $post['boxNextWarLimit']);
                $this->getConfig()->set('war_boxLastWarLimit', $post['boxLastWarLimit']);

                $this->redirect()
                    ->withMessage('saveSuccess')
                    ->to(['action' => 'index']);
            }

            $this->addMessage($validation->getErrorBag()->getErrorMessages(), 'danger', true);
            $errorFields = $validation->getFieldsWithError();
        }

        $this->getView()->set('post', $post);
        $this->getView()->set('errorFields', (isset($errorFields) ? $errorFields : []));
        $this->getView()->set('warsPerPage', $this->getConfig()->get('war_warsPerPage'));
        $this->getView()->set('enemiesPerPage', $this->getConfig()->get('war_enemiesPerPage'));
        $this->getView()->set('groupsPerPage', $this->getConfig()->get('war_groupsPerPage'));
        $this->getView()->set('boxNextWarLimit', $this->getConfig()->get('war_boxNextWarLimit'));
        $this->getView()->set('boxLastWarLimit', $this->getConfig()->get('war_boxLastWarLimit'));
    }
}
