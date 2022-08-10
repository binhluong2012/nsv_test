<?php

/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */

namespace App\Controller;

use Cake\Core\Configure;
use Cake\Database\Expression\QueryExpression;
use Cake\Database\Query;
use Cake\Http\Exception\ForbiddenException;
use Cake\Http\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\ORM\TableRegistry;
use Cake\Mailer\Email;
use CakePdf\Pdf\CakePdf;

/**
 * Static content controller
 *
 * This controller will render views from Template/Pages/
 *
 * @link https://book.cakephp.org/3/en/controllers/pages-controller.html
 */
class PagesController extends AppController
{
    /**
     * Displays a view
     *
     * @param array ...$path Path segments.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Http\Exception\ForbiddenException When a directory traversal attempt.
     * @throws \Cake\Http\Exception\NotFoundException When the view file could not
     *   be found
     * @throws \Cake\View\Exception\MissingTemplateException In debug mode.
     */
    public function display(...$path)
    {
        if (!$path) {
            return $this->redirect('/');
        }


        // Start a new query.
        // $this->set(compact('page', 'subpage'));

        try {
            $this->render(implode('/', $path));
        } catch (MissingTemplateException $exception) {
            if (Configure::read('debug')) {
                throw $exception;
            }
            throw new NotFoundException();
        }
    }

    public function ajaxSearch()
    {
        $this->layout = 'ajax';
        $from = $this->request->getData('from');
        $to = $this->request->getData('to');
        $model = TableRegistry::getTableLocator()->get('Staffs');
        $staffs = $model->find()->where(['FlagDelete' => '0', '']);

        if (is_numeric($from)) {
            $staffs->where(['date(Created_at) <=' =>  date("Y-m-d", strtotime("-" . $from . " days"))]);
        }
        if (is_numeric($to)) {
            $staffs->where(['date(Created_at) >' => date("Y-m-d", strtotime("-" . $to . " days"))]);
        }
        $staffs->where(function (QueryExpression $exp, Query $q) {
            return $exp->isNotNull('Created_at');
        })->order(['StaffID' => 'ASC']);
        $days = [
            '1' => '月',
            '2' => '火',
            '3' => '水',
            '4' => '木',
            '5' => '金',
            '6' => '土',
            '0' => '日'
        ];
        Configure::write('CakePdf', [
            'engine' => 'CakePdf.DomPdf',
            'margin' => [
                'bottom' => 15,
                'left' => 50,
                'right' => 30,
                'top' => 45
            ],
            'orientation' => 'landscape',
            'download' => true,
            'encoding' => 'UTF-8',
        ]);
        $CakePdf = new CakePdf();
        $CakePdf->template('Pages/search');
        $CakePdf->viewVars(['staffs' => $staffs, 'days' => $days]);
        $pdf = $CakePdf->write(APP . 'files' . DS . 'staffs.pdf');
        $this->set(compact('from', 'to', 'staffs', 'days'));
    }

    public function fileDownload()
    {
        $fileName = 'staffs.pdf';
        $file_path = APP . 'files' . DS . $fileName;
        $this->response->file($file_path, array(
            'download' => true,
            'name' => $fileName,
        ));
        return $this->response;
    }

    public function fileSendMail()
    {
        $to = $this->request->getData('email');
        $fileName = 'staffs.pdf';
        $file_path = APP . 'files' . DS . $fileName;
        $email = new Email('smtp');
        $email->setFrom(array('admin@gmail.com' => 'Admin at gMail'));
        $email->setTo($to);
        $email->setEmailFormat('html');
        $email->setSubject('Report');
        $email->setAttachments([
            'staffs.pdf' => [
                'file' => $file_path,
                'mimetype' => 'application/pdf'
            ]
         ]);
        $response = ['status' => true];
        try {
            $email->send('Please check attachment file');
        } catch (\Cake\Network\Exception\SocketException $exception) {
            $response = ['status' => false];
        }

        $content = json_encode($response);
        $this->response = $this->response->withStringBody($content);
        $this->response = $this->response->withType('json');
        return $this->response;
    }
}
