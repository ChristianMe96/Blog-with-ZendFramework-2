<?php

namespace Blog\Controller;


use Blog\Form\ContactForm;
use Blog\InputFilter\MailFilter;
use function Symfony\Component\Debug\Tests\FatalErrorHandler\test_namespaced_function;
use Zend\Form\Form;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class MailController extends AbstractActionController
{
    public function mailFormAction()
    {
        $form = new ContactForm();

        return $this->mailViewModel($form, 'Contact');
    }

    public function sendMailAction()
    {

        $request = $this->getRequest();
        $form = new ContactForm();
        #$commentFilter = new MailFilter();
        #$form->setInputFilter($commentFilter->getInputFilter());
        $form->setData($request->getPost());
        if ($form->isValid()) {
            $transport = (new \Swift_SmtpTransport('smtp.live.com', 587))
                ->setEncryption('tls')
                ->setUsername('christian.meinhard@live.com')
                ->setPassword('leverkusen');

            $mailer = new \Swift_Mailer($transport);

            $message = (new \Swift_Message('Your Message is successfully Submitted.'))
                ->setFrom(['christian.meinhard@live.com' => 'christian.meinhard@live.com'])
                ->setTo('christian.meinhard@live.com')
                ->setReplyTo([$form->getData()['email'] => $form->getData()['name']])
                ->addPart("<p>".$form->getData()['message']."</p>",'text/html');

            $result = $mailer->send($message);

            $this->flashMessenger()->setNamespace('success')->addMessage('Your email has been received and will be processed shortly.');

            return $this->redirect()->toRoute('contact/get');
        }

        return $this->mailViewModel($form, 'Contact');
    }

    public function mailViewModel(Form $form,string $title): ViewModel
    {
        $viewModel = new ViewModel(['form' => $form, 'title' => $title]);
        $viewModel->setTemplate('blog/mail/mail-form');
        return $viewModel;
    }
}