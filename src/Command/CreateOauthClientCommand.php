<?php
/**
 * Created by PhpStorm.
 * User: eric
 * Date: 06/03/18
 * Time: 20:05
 */

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use FOS\OAuthServerBundle\Entity\ClientManager;


class CreateOauthClientCommand extends Command
{
    protected static $defaultName = 'fos:oauth-server:create-client';
    private $client_manager;

    public function __construct(ClientManager $client_manager)
    {
        parent::__construct();
        $this->client_manager = $client_manager;
    }

    protected function configure()
    {
        $this->setName('fos:oauth-server:create-client')->setDescription('Creates a new Oauth client.')->setHelp('This command allows you to create a new oauth client');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $clientManager = $this->client_manager;
        $client = $clientManager->createClient();
        $client->setRedirectUris(array('http://www.example.com'));
        $client->setAllowedGrantTypes(array('token', 'password'));
        $clientManager->updateClient($client);

        $output->writeln('Client was create with success');
    }
}