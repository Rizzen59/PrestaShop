<?php
/**
 * Copyright since 2007 PrestaShop SA and Contributors
 * PrestaShop is an International Registered Trademark & Property of PrestaShop SA
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.md.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/OSL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to https://devdocs.prestashop.com/ for more information.
 *
 * @author    PrestaShop SA and Contributors <contact@prestashop.com>
 * @copyright Since 2007 PrestaShop SA and Contributors
 * @license   https://opensource.org/licenses/OSL-3.0 Open Software License (OSL 3.0)
 */
declare(strict_types=1);

namespace Tests\Unit\Core\Form\ChoiceProvider;

use Generator;
use PHPUnit\Framework\TestCase;
use PrestaShop\PrestaShop\Core\Form\ChoiceProvider\OutOfStockTypeChoiceProvider;
use Symfony\Component\Translation\TranslatorInterface;

class OutOfStockTypeChoiceProviderTest extends TestCase
{
    /**
     * @dataProvider getExpectedChoices
     *
     * @param bool $outOfStockAvailable
     * @param array $expectedChoices
     */
    public function testItProvidesChoicesAsExpected(bool $outOfStockAvailable, array $expectedChoices): void
    {
        $choiceProvider = new OutOfStockTypeChoiceProvider(
            $this->mockTranslator(),
            $outOfStockAvailable
        );

        $this->assertEquals($expectedChoices, $choiceProvider->getChoices());
    }

    /**
     * @return Generator
     */
    public function getExpectedChoices(): Generator
    {
        yield [
            false,
            [
                'Deny orders' => 0,
                'Allow orders' => 1,
                'Use default behavior (Deny orders)' => 2,
            ],
        ];

        yield [
            true,
            [
                'Deny orders' => 0,
                'Allow orders' => 1,
                'Use default behavior (Allow orders)' => 2,
            ],
        ];
    }

    /**
     * @return TranslatorInterface
     */
    private function mockTranslator(): TranslatorInterface
    {
        $mock = $this->createMock(TranslatorInterface::class);

        $mock->method('trans')
            ->willReturnArgument(0);

        return $mock;
    }
}
