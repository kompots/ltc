<?php

namespace AppBundle\Command;

use AppBundle\Entity\EchangeRate;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DomCrawler\Crawler;

class ExchangeRateFetchCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('app:fetch-exchange-rates')
            ->setDescription('Fetches data from bank.lv');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|null|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $crawler = new Crawler();
        $crawler->addXmlContent(file_get_contents('https://www.bank.lv/vk/ecb_rss.xml'));
        $crawler = $crawler->filterXPath('//rss/channel/item');
        foreach ($crawler as $domElement) {
            $data = $domElement->childNodes[7]->nodeValue;
            $pubDate = $domElement->childNodes[9]->nodeValue;

            $exchanges = explode(" ", $data);
            $output->writeln($this->getContainer()->get('console_exchange_rss')->storeRecords($exchanges, $pubDate));

        }
    }
}