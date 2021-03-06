<?php

namespace OroCRM\Bundle\MagentoBundle\Tests\Functional\Model;

use Oro\Bundle\IntegrationBundle\Entity\Channel;
use Oro\Bundle\TestFrameworkBundle\Test\WebTestCase;

use OroCRM\Bundle\MagentoBundle\Entity\Customer;
use OroCRM\Bundle\MagentoBundle\Entity\NewsletterSubscriber;

/**
 * @dbIsolation
 */
class NewsletterSubscriberManagerTest extends WebTestCase
{
    protected function setUp()
    {
        $this->initClient([], $this->generateBasicAuthHeader());
        $this->loadFixtures(['OroCRM\Bundle\MagentoBundle\Tests\Functional\Fixture\LoadNewsletterSubscriberData']);
    }

    public function testCreateFromCustomer()
    {
        /** @var Channel $integration */
        $integration = $this->getReference('integration');

        /** @var Customer $customer */
        $customer = new Customer();
        $customer->setChannel($integration);
        $this->assertEmpty($customer->getNewsletterSubscriber());

        $newsletterSubscriber = $this->getContainer()->get('orocrm_magento.model.newsletter_subscriber_manager')
            ->getOrCreateFromCustomer($customer);

        $this->assertEquals($customer->getEmail(), $newsletterSubscriber->getEmail());
        $this->assertEquals($customer, $newsletterSubscriber->getCustomer());
        $this->assertEquals($customer->getChannel(), $newsletterSubscriber->getChannel());
        $this->assertEquals($customer->getStore(), $newsletterSubscriber->getStore());
        $this->assertEquals($customer->getOrganization(), $newsletterSubscriber->getOrganization());
        $this->assertEquals($customer->getOwner(), $newsletterSubscriber->getOwner());
        $this->assertEquals($customer->getDataChannel(), $newsletterSubscriber->getDataChannel());

        $this->assertEquals(NewsletterSubscriber::STATUS_UNSUBSCRIBED, $newsletterSubscriber->getStatus()->getId());
    }

    public function testGetFromCustomer()
    {
        /** @var Customer $customer */
        $customer = $this->getReference('customer');
        $this->assertNotEmpty($customer->getNewsletterSubscriber());

        $newsletterSubscriber = $this->getContainer()->get('orocrm_magento.model.newsletter_subscriber_manager')
            ->getOrCreateFromCustomer($customer);

        $this->assertEquals($customer, $newsletterSubscriber->getCustomer());
        $this->assertNotEmpty($newsletterSubscriber->getId());

        $this->assertEquals(NewsletterSubscriber::STATUS_SUBSCRIBED, $newsletterSubscriber->getStatus()->getId());
    }
}
