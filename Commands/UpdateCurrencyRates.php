<?php

namespace saltyUpdateCurrencyRates\Commands;

use saltyUpdateCurrencyRates\Components\TableHelper;
use saltyUpdateCurrencyRates\Services\RatesServiceInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Shopware\Commands\ShopwareCommand;
use saltyUpdateCurrencyRates\Services\ConnectionServiceInterface;


class UpdateCurrencyRates extends ShopwareCommand
{
    /**
     * @var ConnectionServiceInterface
     */
    private $connectionService;

    /**
     * @var RatesServiceInterface
     */
    private $ratesService;

    /**
     * UpdateCurrencyRates constructor.
     * @param ConnectionServiceInterface $connectionService
     * @param RatesServiceInterface $ratesService
     */
    public function __construct(ConnectionServiceInterface $connectionService, RatesServiceInterface $ratesService)
    {
        $this->connectionService = $connectionService;
        $this->ratesService = $ratesService;
        parent::__construct(null);
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('salty:Update:CurrencyRates')
            ->setDescription('Receives currency rates from EZB and updates values')
            ->addOption(
                'quiet',
                'q',
                InputOption::VALUE_NONE,
                'No output'
            )
            ->setHelp(<<<EOF
The <info>%command.name%</info> implements a command.
EOF
            );
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $rates = $this->connectionService->get();

        if(!$rates) {
            return;
        }

        $currencies = $this->ratesService->get(array_keys($rates));

        //Table output
        if(!$input->getOption('quiet')) {
            TableHelper::createRatesTable($output, $currencies, $rates);
        }

        $this->ratesService->updateRates($rates, $currencies);

        //TODO: only update if default is EUR
    }
}
