# 📥 Guia de Instalação Completa - Gupshup Partner API Library

## Como Obter os Arquivos

Os arquivos foram criados em **artifacts** nesta conversa. Você pode copiá-los manualmente seguindo este guia.

---

## 📁 Estrutura de Diretórios

Crie a seguinte estrutura no seu projeto Laravel:

```
seu-projeto-laravel/
├── app/
│   ├── Services/
│   │   └── GupshupPartner/
│   │       ├── GupshupPartnerClient.php
│   │       ├── AppManagement.php
│   │       ├── TemplateManagement.php
│   │       ├── MessageManagement.php
│   │       ├── AnalyticsManagement.php
│   │       ├── WalletManagement.php
│   │       ├── FlowManagement.php
│   │       └── Exceptions/
│   │           └── GupshupPartnerException.php
│   ├── Providers/
│   │   └── GupshupPartnerServiceProvider.php
│   └── Facades/
│       └── GupshupPartner.php
├── config/
│   └── gupshup.php
└── .env
```

---

## 🔧 Passo a Passo para Instalação Manual

### 1️⃣ Criar os Diretórios

```bash
# No diretório raiz do seu projeto Laravel
mkdir -p app/Services/GupshupPartner/Exceptions
mkdir -p app/Facades
```

### 2️⃣ Copiar os Arquivos

Acima desta mensagem, você verá vários **artifacts** (caixas azuis/cinzas) com os arquivos criados:

1. **GupshupPartnerClient.php** - Cliente Principal
2. **AppManagement.php** - Gerenciamento de Apps
3. **TemplateManagement.php** - Gerenciamento de Templates
4. **MessageManagement.php** - Gerenciamento de Mensagens
5. **AnalyticsManagement.php** - Análises e Relatórios
6. **WalletManagement.php e FlowManagement.php**
7. **GupshupPartnerException.php** - Classe de Exceção
8. **config/gupshup.php** - Arquivo de Configuração
9. **GupshupPartnerServiceProvider.php** - Service Provider
10. **GupshupPartner.php** - Facade Laravel
11. **.env.example** - Exemplo de Configuração

**Para cada arquivo:**
- Clique no artifact
- Copie todo o conteúdo
- Cole no arquivo correspondente no seu projeto

### 3️⃣ Registrar o Service Provider

Edite o arquivo `config/app.php`:

```php
return [
    // ...
    
    'providers' => [
        // ... outros providers
        
        App\Providers\GupshupPartnerServiceProvider::class,
    ],
    
    'aliases' => [
        // ... outros aliases
        
        'GupshupPartner' => App\Facades\GupshupPartner::class,
    ],
];
```

### 4️⃣ Configurar Variáveis de Ambiente

Adicione no seu arquivo `.env`:

```env
GUPSHUP_PARTNER_EMAIL=seu-email@exemplo.com
GUPSHUP_PARTNER_PASSWORD=sua-senha
GUPSHUP_DEFAULT_APP_ID=seu-app-id
GUPSHUP_CACHE_ENABLED=true
```

### 5️⃣ Limpar o Cache do Laravel

```bash
php artisan config:clear
php artisan cache:clear
php artisan config:cache
```

---

## 📋 Checklist de Instalação

- [ ] Diretórios criados
- [ ] Arquivo `GupshupPartnerClient.php` copiado para `app/Services/GupshupPartner/`
- [ ] Arquivo `AppManagement.php` copiado para `app/Services/GupshupPartner/`
- [ ] Arquivo `TemplateManagement.php` copiado para `app/Services/GupshupPartner/`
- [ ] Arquivo `MessageManagement.php` copiado para `app/Services/GupshupPartner/`
- [ ] Arquivo `AnalyticsManagement.php` copiado para `app/Services/GupshupPartner/`
- [ ] Arquivo `WalletManagement.php` copiado para `app/Services/GupshupPartner/`
- [ ] Arquivo `FlowManagement.php` copiado para `app/Services/GupshupPartner/`
- [ ] Arquivo `GupshupPartnerException.php` copiado para `app/Services/GupshupPartner/Exceptions/`
- [ ] Arquivo `GupshupPartnerServiceProvider.php` copiado para `app/Providers/`
- [ ] Arquivo `GupshupPartner.php` copiado para `app/Facades/`
- [ ] Arquivo `gupshup.php` copiado para `config/`
- [ ] Service Provider registrado em `config/app.php`
- [ ] Facade registrado em `config/app.php`
- [ ] Variáveis de ambiente configuradas no `.env`
- [ ] Cache do Laravel limpo

---

## 🧪 Teste a Instalação

Crie um arquivo de teste `routes/web.php`:

```php
use App\Facades\GupshupPartner;

Route::get('/test-gupshup', function () {
    try {
        // Testa a autenticação
        $token = GupshupPartner::getPartnerToken();
        
        // Testa listagem de apps
        $apps = GupshupPartner::apps()->list();
        
        return response()->json([
            'status' => 'success',
            'message' => 'Gupshup Partner API está funcionando!',
            'apps_count' => count($apps['partnerAppsList'] ?? [])
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => $e->getMessage()
        ], 500);
    }
});
```

Acesse: `http://seu-site.local/test-gupshup`

---

## 🎯 Lista dos Artifacts Disponíveis

Procure acima desta mensagem pelos seguintes artifacts (caixas com código):

1. **GupshupPartnerClient.php - Cliente Principal**
2. **AppManagement.php - Gerenciamento de Apps**
3. **TemplateManagement.php - Gerenciamento de Templates**
4. **MessageManagement.php - Gerenciamento de Mensagens**
5. **AnalyticsManagement.php - Análises e Relatórios**
6. **WalletManagement.php e FlowManagement.php**
7. **GupshupPartnerException.php - Classe de Exceção**
8. **config/gupshup.php - Arquivo de Configuração**
9. **GupshupPartnerServiceProvider.php - Service Provider**
10. **GupshupPartner.php - Facade Laravel**
11. **EXEMPLOS_DE_USO.md - Guia Completo**
12. **README.md - Documentação Principal**
13. **.env.example - Exemplo de Configuração**

---

## 🆘 Precisa de Ajuda?

Se você quiser que eu crie um **script de instalação automática** ou um **arquivo ZIP**, posso fazer isso também!

Opções:
1. **Script Bash** - Para instalar automaticamente todos os arquivos
2. **Comando Artisan** - Para criar os arquivos via comando Laravel
3. **Composer Package** - Para instalar via composer

Me avise qual você prefere!

---

## 💡 Dica Rápida

Você pode:
1. Rolar para cima nesta conversa
2. Procurar pelas caixas azuis/cinzas (artifacts)
3. Clicar no botão de copiar em cada uma
4. Colar no arquivo correspondente

Cada artifact tem um título que indica onde o arquivo deve ser salvo!