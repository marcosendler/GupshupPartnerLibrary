# Biblioteca Gupshup Partner API para Laravel

Biblioteca completa para integração com as APIs de Parceiro do Gupshup.

## Instalação

### 1. Copie os arquivos para sua estrutura Laravel:

```
app/
├── Services/
│   └── GupshupPartner/
│       ├── GupshupPartnerClient.php
│       ├── AppManagement.php
│       ├── TemplateManagement.php
│       ├── MessageManagement.php
│       ├── AnalyticsManagement.php
│       ├── WalletManagement.php
│       ├── FlowManagement.php
│       └── Exceptions/
│           └── GupshupPartnerException.php
├── Providers/
│   └── GupshupPartnerServiceProvider.php
└── Facades/
    └── GupshupPartner.php
config/
└── gupshup.php
```

### 2. Registre o Service Provider

No arquivo `config/app.php`, adicione:

```php
'providers' => [
    // ...
    App\Providers\GupshupPartnerServiceProvider::class,
],

'aliases' => [
    // ...
    'GupshupPartner' => App\Facades\GupshupPartner::class,
],
```

### 3. Configure as variáveis de ambiente

No arquivo `.env`:

```env
GUPSHUP_PARTNER_EMAIL=seu-email@exemplo.com
GUPSHUP_PARTNER_PASSWORD=sua-senha
GUPSHUP_DEFAULT_APP_ID=seu-app-id
GUPSHUP_CACHE_ENABLED=true
GUPSHUP_LOGGING_ENABLED=true
```

### 4. Publique a configuração (opcional)

```bash
php artisan vendor:publish --tag=gupshup-config
```

---

## Exemplos de Uso

### 1. Gerenciamento de Apps

```php
use App\Facades\GupshupPartner;

// Listar todos os apps
$apps = GupshupPartner::apps()->list();

// Vincular um app ao parceiro
$linkedApp = GupshupPartner::apps()->link('API_KEY', 'Nome do App');

// Obter token de acesso para um app
$token = GupshupPartner::apps()->getToken('app-id-123');

// Obter detalhes de um app
$appDetails = GupshupPartner::apps()->get('app-id-123');

// Verificar Quality Rating e Limits
$quality = GupshupPartner::apps()->getQualityAndLimits('app-id-123');

// Habilitar template messaging
GupshupPartner::apps()->toggleTemplateMessaging('app-id-123', true);

// Configurar ice breakers
GupshupPartner::apps()->setIceBreakers('app-id-123', [
    'Olá! Como posso ajudar?',
    'Ver catálogo',
    'Falar com atendente',
    'Rastrear pedido'
]);
```

### 2. Gerenciamento de Templates

```php
use App\Facades\GupshupPartner;

$appId = 'seu-app-id';

// Listar todos os templates
$templates = GupshupPartner::templates()->list($appId);

// Criar template de texto
$textTemplate = GupshupPartner::templates()->createText($appId, [
    'elementName' => 'boas_vindas',
    'category' => 'UTILITY',
    'languageCode' => 'pt_BR',
    'data' => 'Olá {{1}}, bem-vindo(a) à {{2}}!',
    'example' => 'Olá João, bem-vindo(a) à Minha Empresa!',
]);

// Criar template com imagem
$imageTemplate = GupshupPartner::templates()->createImage($appId, [
    'elementName' => 'promocao_imagem',
    'category' => 'MARKETING',
    'languageCode' => 'pt_BR',
    'data' => 'Confira nossa promoção especial! {{1}}',
    'headerType' => 'IMAGE',
    'headerUrl' => 'https://exemplo.com/promocao.jpg',
]);

// Criar template com vídeo
$videoTemplate = GupshupPartner::templates()->createVideo($appId, [
    'elementName' => 'tutorial_video',
    'category' => 'UTILITY',
    'languageCode' => 'pt_BR',
    'data' => 'Assista ao tutorial: {{1}}',
    'headerType' => 'VIDEO',
    'headerUrl' => 'https://exemplo.com/tutorial.mp4',
]);

// Criar template com botões
$buttonTemplate = GupshupPartner::templates()->createText($appId, [
    'elementName' => 'confirmacao_pedido',
    'category' => 'UTILITY',
    'languageCode' => 'pt_BR',
    'data' => 'Seu pedido #{{1}} foi confirmado!',
    'buttons' => [
        [
            'type' => 'QUICK_REPLY',
            'text' => 'Rastrear Pedido'
        ],
        [
            'type' => 'URL',
            'text' => 'Ver Detalhes',
            'url' => 'https://exemplo.com/pedido/{{1}}'
        ]
    ]
]);

// Criar template carrossel
$carouselTemplate = GupshupPartner::templates()->createCarouselImage($appId, [
    'elementName' => 'produtos_carousel',
    'category' => 'MARKETING',
    'languageCode' => 'pt_BR',
    'cards' => [
        [
            'components' => [
                ['type' => 'HEADER', 'format' => 'IMAGE'],
                ['type' => 'BODY', 'text' => 'Produto 1: {{1}}'],
                ['type' => 'BUTTONS', 'buttons' => [
                    ['type' => 'URL', 'text' => 'Comprar', 'url' => 'https://loja.com/p1']
                ]]
            ]
        ],
        // Mais cards...
    ]
]);

// Obter templates aprovados
$approved = GupshupPartner::templates()->getApproved($appId);

// Obter templates rejeitados
$rejected = GupshupPartner::templates()->getRejected($appId);

// Editar template
$edited = GupshupPartner::templates()->edit($appId, 'template-id', [
    'data' => 'Novo texto do template',
]);

// Deletar template
GupshupPartner::templates()->delete($appId, 'template-id');
```

### 3. Envio de Mensagens

```php
use App\Facades\GupshupPartner;

$appId = 'seu-app-id';
$destination = '5511999999999'; // Número com código do país

// Enviar mensagem com template de texto
$response = GupshupPartner::messages()->sendTextTemplate(
    $appId,
    $destination,
    'template-id',
    ['João', 'Minha Empresa'] // Parâmetros do template
);

// Enviar mensagem com template de imagem
$response = GupshupPartner::messages()->sendImageTemplate(
    $appId,
    $destination,
    'template-id',
    ['Promoção Especial'],
    'https://exemplo.com/imagem.jpg' // URL da imagem
);

// Enviar mensagem com template de vídeo
$response = GupshupPartner::messages()->sendVideoTemplate(
    $appId,
    $destination,
    'template-id',
    ['Tutorial Completo'],
    'https://exemplo.com/video.mp4'
);

// Enviar mensagem com template de localização
$response = GupshupPartner::messages()->sendLocationTemplate(
    $appId,
    $destination,
    'template-id',
    ['Nossa Loja Principal'],
    [
        'latitude' => -23.550520,
        'longitude' => -46.633308,
        'name' => 'Loja Centro',
        'address' => 'Av. Paulista, 1000'
    ]
);

// Enviar mensagem com catálogo
$response = GupshupPartner::messages()->sendCatalogTemplate(
    $appId,
    $destination,
    'template-id',
    ['Confira nossos produtos']
);

// Enviar mensagem carrossel
$response = GupshupPartner::messages()->sendCarouselTemplate(
    $appId,
    $destination,
    'template-id',
    [
        ['image' => 'url1', 'text' => 'Produto 1'],
        ['image' => 'url2', 'text' => 'Produto 2'],
    ]
);

// Gerar Media ID para upload
$mediaId = GupshupPartner::messages()->generateMediaId($appId);

// Definir validade de mensagem (utility)
GupshupPartner::messages()->setUtilityValidity(
    $appId,
    'template-id',
    30 // minutos
);
```

### 4. Analytics e Relatórios

```php
use App\Facades\GupshupPartner;
use Carbon\Carbon;

$appId = 'seu-app-id';
$hoje = Carbon::now()->format('Y-m-d');
$umaSemanaAtras = Carbon::now()->subWeek()->format('Y-m-d');

// Obter logs de mensagens recebidas
$inbound = GupshupPartner::analytics()->getInboundLogs(
    $appId,
    $umaSemanaAtras,
    $hoje
);

// Obter logs de mensagens enviadas de hoje
$outbound = GupshupPartner::analytics()->getOutboundLogs($appId, $hoje);

// Obter uso diário
$dailyUsage = GupshupPartner::analytics()->getDailyUsage(
    $appId,
    $umaSemanaAtras,
    $hoje
);

// Obter conversas por categoria
$conversations = GupshupPartner::analytics()->getConversationsByCategory(
    $appId,
    $umaSemanaAtras,
    $hoje
);

// Obter estatísticas de entrega
$delivery = GupshupPartner::analytics()->getDeliveryStats(
    $appId,
    $umaSemanaAtras,
    $hoje
);

// Obter estatísticas de leitura
$read = GupshupPartner::analytics()->getReadStats(
    $appId,
    $umaSemanaAtras,
    $hoje
);

// Obter mensagens falhadas
$failed = GupshupPartner::analytics()->getFailedStats(
    $appId,
    $umaSemanaAtras,
    $hoje
);

// Obter relatório completo
$fullReport = GupshupPartner::analytics()->getFullReport(
    $appId,
    $umaSemanaAtras,
    $hoje
);

// Analytics de hoje
$todayAnalytics = GupshupPartner::analytics()->getTodayAnalytics($appId);

// Analytics da semana
$weekAnalytics = GupshupPartner::analytics()->getWeekAnalytics($appId);

// Analytics do último mês
$monthAnalytics = GupshupPartner::analytics()->getLastMonthAnalytics($appId);

// Obter métricas resumidas
$summary = GupshupPartner::analytics()->getSummaryMetrics(
    $appId,
    $umaSemanaAtras,
    $hoje
);

// Resultado exemplo:
// [
//     'total_sent' => 1000,
//     'total_delivered' => 980,
//     'total_read' => 850,
//     'total_failed' => 20,
//     'delivery_rate' => 98.0,
//     'read_rate' => 86.7,
//     'failure_rate' => 2.0
// ]
```

### 5. Gerenciamento de Wallet (Carteira)

```php
use App\Facades\GupshupPartner;

$walletId = 'sua-wallet-id';

// Obter saldo da carteira
$balance = GupshupPartner::wallet()->getBalance($walletId);

// Obter histórico
$history = GupshupPartner::wallet()->getHistory(
    $walletId,
    '2024-01-01',
    '2024-01-31'
);

// Obter extrato mensal
$statement = GupshupPartner::wallet()->getStatement($walletId, '2024-01');

// Obter informações de overdraft
$overdraft = GupshupPartner::wallet()->getOverdraft($walletId);

// Definir limite de overdraft
$setOverdraft = GupshupPartner::wallet()->setOverdraftLimit($walletId, 1000.00);

// Obter histórico de consumo (últimos 90 dias)
$consumption = GupshupPartner::wallet()->getConsumptionHistory($walletId);

// Obter detalhes de comissão
$commission = GupshupPartner::wallet()->getCommission($walletId);

// Obter créditos expirados
$expired = GupshupPartner::wallet()->getExpiredCredits($walletId);
```

### 6. Gerenciamento de Flows

```php
use App\Facades\GupshupPartner;

$appId = 'seu-app-id';

// Listar todos os flows
$flows = GupshupPartner::flows()->list($appId);

// Criar novo flow
$newFlow = GupshupPartner::flows()->create($appId, 'Meu Flow', ['UTILITY']);

// Atualizar flow
$updated = GupshupPartner::flows()->update($appId, 'flow-id', [
    'name' => 'Novo Nome',
]);

// Atualizar JSON do flow
$jsonUpdated = GupshupPartner::flows()->updateJson($appId, 'flow-id', [
    // JSON do flow
]);

// Obter JSON do flow
$flowJson = GupshupPartner::flows()->getJson($appId, 'flow-id');

// Obter URL de preview
$previewUrl = GupshupPartner::flows()->getPreviewUrl($appId, 'flow-id');

// Publicar flow
$published = GupshupPartner::flows()->publish($appId, 'flow-id');

// Depreciar flow
$deprecated = GupshupPartner::flows()->deprecate($appId, 'flow-id');

// Deletar flow
$deleted = GupshupPartner::flows()->delete($appId, 'flow-id');

// Importar flow do Meta Playground
$imported = GupshupPartner::flows()->importFromMeta(
    $appId,
    'Flow Importado',
    '/path/to/meta-flow.json'
);

// Gerenciar subscrições
$subscribed = GupshupPartner::flows()->subscribe($appId, 'flow-id', [
    'endpoint' => 'https://seu-webhook.com',
]);

// Remover subscrição específica
GupshupPartner::flows()->unsubscribe($appId, 'flow-id', 'subscription-id');

// Remover todas as subscrições
GupshupPartner::flows()->unsubscribeAll($appId, 'flow-id');
```

---

## Uso em Controllers

### Exemplo de Controller Completo

```php
<?php

namespace App\Http\Controllers;

use App\Facades\GupshupPartner;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class WhatsAppController extends Controller
{
    protected string $appId;

    public function __construct()
    {
        $this->appId = config('gupshup.default_app.id');
    }

    /**
     * Lista todos os apps
     */
    public function listApps(): JsonResponse
    {
        try {
            $apps = GupshupPartner::apps()->list();
            return response()->json($apps);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Lista templates
     */
    public function listTemplates(): JsonResponse
    {
        try {
            $templates = GupshupPartner::templates()->list($this->appId);
            return response()->json($templates);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Envia mensagem
     */
    public function sendMessage(Request $request): JsonResponse
    {
        $request->validate([
            'destination' => 'required|string',
            'template_id' => 'required|string',
            'params' => 'array',
        ]);

        try {
            $response = GupshupPartner::messages()->sendTextTemplate(
                $this->appId,
                $request->destination,
                $request->template_id,
                $request->params ?? []
            );

            return response()->json($response);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Obtém analytics do dia
     */
    public function getTodayAnalytics(): JsonResponse
    {
        try {
            $analytics = GupshupPartner::analytics()->getTodayAnalytics($this->appId);
            return response()->json($analytics);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Obtém saldo da carteira
     */
    public function getWalletBalance(string $walletId): JsonResponse
    {
        try {
            $balance = GupshupPartner::wallet()->getBalance($walletId);
            return response()->json($balance);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
```

---

## Tratamento de Erros

```php
use App\Services\GupshupPartner\Exceptions\GupshupPartnerException;

try {
    $templates = GupshupPartner::templates()->list($appId);
} catch (GupshupPartnerException $e) {
    // Erro específico da API Gupshup
    $statusCode = $e->getStatusCode();
    $responseData = $e->getResponseData();
    $message = $e->getMessage();
    
    Log::error('Erro Gupshup', [
        'status' => $statusCode,
        'message' => $message,
        'data' => $responseData,
    ]);
} catch (\Exception $e) {
    // Outros erros
    Log::error('Erro geral', ['message' => $e->getMessage()]);
}
```

---

## Uso Direto (sem Facade)

```php
use App\Services\GupshupPartner\GupshupPartnerClient;

$client = new GupshupPartnerClient('email@exemplo.com', 'senha');

// Usando os serviços
$apps = $client->apps()->list();
$templates = $client->templates()->list($appId);
$analytics = $client->analytics()->getTodayAnalytics($appId);
```

---

## Uso com Dependency Injection

```php
use App\Services\GupshupPartner\GupshupPartnerClient;

class MyService
{
    public function __construct(
        protected GupshupPartnerClient $gupshup
    ) {}

    public function sendWelcomeMessage(string $phone)
    {
        return $this->gupshup->messages()->sendTextTemplate(
            config('gupshup.default_app.id'),
            $phone,
            'welcome_template',
            ['Nome do Cliente']
        );
    }
}
```

---

## Recursos Adicionais

### Cache Automático

A biblioteca usa cache automático para:
- Partner Token (23 horas)
- App Tokens (23 horas)

Para forçar refresh:
```php
$token = GupshupPartner::getPartnerToken(true); // Force refresh
$appToken = GupshupPartner::apps()->getToken($appId, true); // Force refresh
```

### Logging

Ative logging no `.env`:
```env
GUPSHUP_LOGGING_ENABLED=true
GUPSHUP_LOG_CHANNEL=daily
GUPSHUP_LOG_LEVEL=info
```

---

## API Reference Completa

Todas as classes seguem o padrão:
- **AppManagement**: Gerenciamento de aplicativos
- **TemplateManagement**: CRUD de templates
- **MessageManagement**: Envio de mensagens
- **AnalyticsManagement**: Relatórios e métricas
- **WalletManagement**: Gestão financeira
- **FlowManagement**: Flows do WhatsApp

Cada método retorna array com a resposta da API ou lança `GupshupPartnerException` em caso de erro.