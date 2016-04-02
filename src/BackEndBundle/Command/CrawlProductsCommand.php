<?php

namespace BackEndBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CrawlProductsCommand extends ContainerAwareCommand
{
    public function configure()
    {
        $this
            ->setName('crawl:products')
            ->setDescription('Add some products randomly crawled from internet')
        ;
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $product = $this->getContainer()->get('product_crawler')->crawlProduct();
        
        $em = $this->getContainer()->get('doctrine')->getManager();
        $em->persist($product);
        $em->flush();

        $output->writeln($product->getName() . ' has been added to database');

        $logger = $this->getContainer()->get('logger');
        $logger->info('crawl:products command just ran');
    }
}
