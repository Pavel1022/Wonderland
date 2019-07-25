<?php

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.
// Returns the private 'security.firewall.map.context.secured_area' shared service.

include_once $this->targetDirs[3].'/vendor/symfony/symfony/src/Symfony/Bundle/SecurityBundle/Security/FirewallContext.php';
include_once $this->targetDirs[3].'/vendor/symfony/symfony/src/Symfony/Component/Security/Http/Util/TargetPathTrait.php';
include_once $this->targetDirs[3].'/vendor/symfony/symfony/src/Symfony/Component/Security/Http/Firewall/ExceptionListener.php';
include_once $this->targetDirs[3].'/vendor/symfony/symfony/src/Symfony/Component/Security/Http/EntryPoint/AuthenticationEntryPointInterface.php';
include_once $this->targetDirs[3].'/vendor/symfony/symfony/src/Symfony/Component/Security/Http/EntryPoint/FormAuthenticationEntryPoint.php';
include_once $this->targetDirs[3].'/vendor/symfony/symfony/src/Symfony/Component/Security/Http/Firewall/ListenerInterface.php';
include_once $this->targetDirs[3].'/vendor/symfony/symfony/src/Symfony/Component/Security/Http/Firewall/LogoutListener.php';
include_once $this->targetDirs[3].'/vendor/symfony/symfony/src/Symfony/Component/Security/Http/Logout/LogoutSuccessHandlerInterface.php';
include_once $this->targetDirs[3].'/vendor/symfony/symfony/src/Symfony/Component/Security/Http/Logout/DefaultLogoutSuccessHandler.php';
include_once $this->targetDirs[3].'/vendor/symfony/symfony/src/Symfony/Component/Security/Http/Logout/LogoutHandlerInterface.php';
include_once $this->targetDirs[3].'/vendor/symfony/symfony/src/Symfony/Component/Security/Http/Logout/CsrfTokenClearingLogoutHandler.php';
include_once $this->targetDirs[3].'/vendor/symfony/symfony/src/Symfony/Component/Security/Http/Logout/SessionLogoutHandler.php';
include_once $this->targetDirs[3].'/vendor/symfony/symfony/src/Symfony/Bundle/SecurityBundle/Security/FirewallConfig.php';

$a = ${($_ = isset($this->services['security.token_storage']) ? $this->services['security.token_storage'] : ($this->services['security.token_storage'] = new \Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage())) && false ?: '_'};
$b = ${($_ = isset($this->services['security.http_utils']) ? $this->services['security.http_utils'] : $this->load('getSecurity_HttpUtilsService.php')) && false ?: '_'};
$c = new \Symfony\Component\Security\Http\Firewall\LogoutListener($a, $b, new \Symfony\Component\Security\Http\Logout\DefaultLogoutSuccessHandler($b, 'homepage'), ['csrf_parameter' => '_csrf_token', 'csrf_token_id' => 'logout', 'logout_path' => 'security_logout']);
$c->addHandler(new \Symfony\Component\Security\Http\Logout\CsrfTokenClearingLogoutHandler(${($_ = isset($this->services['security.csrf.token_storage']) ? $this->services['security.csrf.token_storage'] : $this->load('getSecurity_Csrf_TokenStorageService.php')) && false ?: '_'}));
$c->addHandler(new \Symfony\Component\Security\Http\Logout\SessionLogoutHandler());

return $this->services['security.firewall.map.context.secured_area'] = new \Symfony\Bundle\SecurityBundle\Security\FirewallContext(new RewindableGenerator(function () {
    yield 0 => ${($_ = isset($this->services['security.channel_listener']) ? $this->services['security.channel_listener'] : $this->load('getSecurity_ChannelListenerService.php')) && false ?: '_'};
    yield 1 => ${($_ = isset($this->services['security.context_listener.0']) ? $this->services['security.context_listener.0'] : $this->load('getSecurity_ContextListener_0Service.php')) && false ?: '_'};
    yield 2 => ${($_ = isset($this->services['security.authentication.listener.form.secured_area']) ? $this->services['security.authentication.listener.form.secured_area'] : $this->load('getSecurity_Authentication_Listener_Form_SecuredAreaService.php')) && false ?: '_'};
    yield 3 => ${($_ = isset($this->services['security.authentication.listener.anonymous.secured_area']) ? $this->services['security.authentication.listener.anonymous.secured_area'] : $this->load('getSecurity_Authentication_Listener_Anonymous_SecuredAreaService.php')) && false ?: '_'};
    yield 4 => ${($_ = isset($this->services['security.access_listener']) ? $this->services['security.access_listener'] : $this->load('getSecurity_AccessListenerService.php')) && false ?: '_'};
}, 5), new \Symfony\Component\Security\Http\Firewall\ExceptionListener($a, ${($_ = isset($this->services['security.authentication.trust_resolver']) ? $this->services['security.authentication.trust_resolver'] : ($this->services['security.authentication.trust_resolver'] = new \Symfony\Component\Security\Core\Authentication\AuthenticationTrustResolver('Symfony\\Component\\Security\\Core\\Authentication\\Token\\AnonymousToken', 'Symfony\\Component\\Security\\Core\\Authentication\\Token\\RememberMeToken'))) && false ?: '_'}, $b, 'secured_area', new \Symfony\Component\Security\Http\EntryPoint\FormAuthenticationEntryPoint(${($_ = isset($this->services['http_kernel']) ? $this->services['http_kernel'] : $this->getHttpKernelService()) && false ?: '_'}, $b, 'security_login', false), NULL, NULL, ${($_ = isset($this->services['monolog.logger.security']) ? $this->services['monolog.logger.security'] : $this->load('getMonolog_Logger_SecurityService.php')) && false ?: '_'}, false), $c, new \Symfony\Bundle\SecurityBundle\Security\FirewallConfig('secured_area', 'security.user_checker', 'security.request_matcher.00qf1z7', true, false, 'security.user.provider.concrete.database_users', 'secured_area', 'security.authentication.form_entry_point.secured_area', NULL, NULL, [0 => 'form_login', 1 => 'anonymous'], NULL));
