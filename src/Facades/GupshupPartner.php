<?php

namespace GupshupPartner\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static string getPartnerToken(bool $forceRefresh = false)
 * @method static mixed get(string $endpoint, array $params = [])
 * @method static mixed post(string $endpoint, array $data = [])
 * @method static mixed put(string $endpoint, array $data = [])
 * @method static mixed delete(string $endpoint, array $data = [])
 *
 * @method static \GupshupPartner\AppManagement apps()
 * @method static \GupshupPartner\TemplateManagement templates()
 * @method static \GupshupPartner\MessageManagement messages()
 * @method static \GupshupPartner\AnalyticsManagement analytics()
 * @method static \GupshupPartner\WalletManagement wallet()
 * @method static \GupshupPartner\FlowManagement flows()
 * @see \GupshupPartner\GupshupPartnerClient
 */
class GupshupPartner extends Facade
{
    /**
     * Get the registered name of the component.
     */
    protected static function getFacadeAccessor(): string
    {
        return 'gupshup.partner';
    }
}
