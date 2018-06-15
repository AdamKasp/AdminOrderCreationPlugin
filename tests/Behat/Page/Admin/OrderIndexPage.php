<?php

declare(strict_types=1);

namespace Tests\Sylius\AdminOrderCreationPlugin\Behat\Page\Admin;

use Behat\Mink\Exception\ElementNotFoundException;
use Behat\Mink\Session;
use Sylius\Behat\Page\Admin\Order\IndexPage;
use Sylius\Behat\Service\Accessor\TableAccessorInterface;
use Symfony\Component\Routing\RouterInterface;

final class OrderIndexPage extends IndexPage implements OrderIndexPageInterface
{
    /** @var TableAccessorInterface */
    private $tableAccessor;

    public function __construct(
        Session $session,
        array $parameters,
        RouterInterface $router,
        TableAccessorInterface $tableAccessor,
        $routeName
    ) {
        parent::__construct($session, $parameters, $router, $tableAccessor, $routeName);

        $this->tableAccessor = $tableAccessor;
    }

    public function createOrder(): void
    {
        $this->getDocument()->clickLink('Create');
    }

    public function countOrders(array $parameters): int
    {
        try {
            $rows = $this->tableAccessor->getRowsWithFields($this->getElement('table'), $parameters);

            return count($rows);
        } catch (\InvalidArgumentException $exception) {
            return 0;
        } catch (ElementNotFoundException $exception) {
            return 0;
        }
    }
}
