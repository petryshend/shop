<?php

namespace BackEndBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CrawlProductsCommand extends ContainerAwareCommand
{
    public function configure()
    {
        $this
            ->setName('crawl:products')
            ->setDescription('Add some products randomly crawled from internet')
            ->addArgument(
                'count',
                InputArgument::OPTIONAL,
                'How many products do you want to add?'
            )
        ;
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $count = $input->getArgument('count') ? intval($input->getArgument('count')) : 1;
        dump($count);
        $crawlResults = $this->getContainer()->get('product_crawler')->crawl();
        $output->writeln($crawlResults);


        $logger = $this->getContainer()->get('logger');
        $logger->info('crawl:products command just ran');
    }
}
