<?php

namespace App\Infrastructure\Command;

use App\Domain\Manager\CategoryManager;
use App\Domain\Manager\ProductManager;
use App\Infrastructure\ApiClient\ElasticsearchClient;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'app:elasticsearch-index',
    description: 'Index all products and categories'
)]
class ElasticsearchIndexerCommand extends Command
{
    public function __construct(
        private ProductManager $productManager,
        private CategoryManager $categoryManager,
        private ElasticsearchClient $elasticsearchClient,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln([
            'Indexing products',
            '============'
        ]);
        $this->indexProducts();
        $output->writeln('Indexed products');

        $output->writeln([
            'Indexing categories',
            '============'
        ]);
        $this->indexCategories();
        $output->writeln('Indexed products');


        return Command::SUCCESS;
    }

    protected function indexProducts()
    {
        $productList = $this->productManager->getProductList();

        foreach ($productList as $product) {
            $this->elasticsearchClient->indexProduct($product);
        }
    }

    protected function indexCategories()
    {
        $categoryList = $this->categoryManager->getCategoryList();

        foreach ($categoryList as $category) {
            $this->elasticsearchClient->indexCategory($category);
        }
    }
}