# Atenção:

## Este módulo é apenas compatível com Prestashop 1.6 a 1.7. Para Prestashop 8.0 e superior, por favor use o [módulo de pagamento Prestashop 8.0 Ifthenpay](https://github.com/ifthenpay/prestashop8)

</br>
</br>

# Módulo de pagamentos Ifthenpay Prestashop 1.7

Ler em ![Português](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/en/pt.png) [Português](readme.pt.md), e ![Inglês](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/en/en.png) [Inglês](readme.md)

[1. Introdução](#introdução)

[2. Compatibilidade](#compatibilidade)

[3. Instalação](#instalação)

[4. Configuração](#configuração)
  * [Chave Backoffice](#chave-backoffice)
  * [Multibanco](#multibanco)
  * [Multibanco com Referências Dinâmicas](#multibanco-com-referências-dinâmicas)
  * [MB WAY](#mb-way)
  * [Cartão de Crédito](#cartão-de-crédito)
  * [Payshop](#payshop)
  * [Cofidis Pay](#cofidis-pay)
  * [Pix](#pix)
  * [Ifthenpay Gateway](#ifthenpay-gateway)
  

[5. Editar Dados de Pagamento](#editar-dados-de-pagamento)
  * [Atualizar Dados de Pagamento](#atualizar-dados-de-pagamento)
  * [Reenviar Dados de Pagamento](#reenviar-dados-de-pagamento)
  * [Relembrar Dados de Pagamento](#relembrar-dados-de-pagamento)
  * [Escolher Método de Pagamento](#escolher-método-de-pagamento)
  

[6. Outros](#outros)
  * [Suporte](#suporte)
  * [Pedir Conta](#pedir-conta)
  * [Requerer criação de conta adicional](#requerer-criação-de-conta-adicional)
  * [Logs](#Logs)
  * [Reset de Configuração](#reset-de-configuração)
  * [Atualizações](#atualizações)
  * [Modo Sandbox](#modo-sandbox)
  * [Callback](#callback)
  * [Testar Callback](#testar-callback)
  * [Bugs conhecidos e soluções](#bugs-conhecidos-e-soluções)


[7. Experiência do Utilizador Consumidor](#experiência-do-utilizador-consumidor)
  * [Pagar encomenda com Multibanco](#pagar-encomenda-com-multibanco)
  * [Pagar encomenda com Payshop](#pagar-encomenda-com-payshop)
  * [Pagar encomenda com MB WAY](#pagar-encomenda-com-mb-way)
  * [Pagar encomenda com Credit Card](#pagar-encomenda-com-credit-card)
  * [Pagar encomenda com Cofidis Pay](#pagar-encomenda-com-cofidis-pay)
  * [Pagar encomenda com Pix](#pagar-encomenda-com-pix)
  * [Pagar encomenda com Ifthenpay Gateway](#pagar-encomenda-com-ifthenpay-gateway)



# Introdução
![img](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/en/payment_methods_banner.png)

**Este é o plugin Ifthenpay para a plataforma de e-commerce Prestashop**

**Multibanco** é um método de pagamento que permite ao consumidor pagar com referência bancária.
Este módulo permite gerar referências de pagamento que o consumidor pode usar para pagar a sua encomenda numa caixa multibanco ou num serviço online de Home Banking. Este plugin usa a Ifthenpay, uma das várias gateways disponíveis em Portugal.

**MB WAY** é a primeira solução inter-bancos que permite a compra e transferência imediata por via de smartphone e tablet.
Este módulo permite gerar um pedido de pagamento ao smartphone do consumidor, e este pode autorizar o pagamento da sua encomenda na aplicação MB WAY. Este plugin usa a Ifthenpay, uma das várias gateways disponíveis em Portugal.

**Payshop** é um método de pagamento que permite ao consumidor pagar com referência payshop.
Este módulo permite gerar uma referência de pagamento que o consumidor pode usar para pagar a sua encomenda num agente Payshop ou CTT. Este plugin usa a Ifthenpay, uma das várias gateways disponíveis em Portugal.

**Cartão de Crédito** Este módulo permite gerar um pagamento por Visa ou Master card, que o consumidor pode usar para pagar a sua encomenda. Este plugin usa a Ifthenpay, uma das várias gateways disponíveis em Portugal.

**Cofidis Pay** é uma solução de pagamento que facilita o pagamento de compras ao dividir o valor até 12 prestações sem juros. Este módulo utiliza uma das várias gateways/serviços disponíveis em Portugal, a IfthenPay.

**É necessário contrato com a Ifthenpay**

Mais informações em [Ifthenpay](https://ifthenpay.com). 


# Compatibilidade

Use a tabela abaixo para verificar a compatibilidade do módulo Ifthenpay com a sua loja online.
|                           | Prestashop 1.6 | Prestashop 1.7 [1.7.0 - 1.7.8] |
|---------------------------|----------------|--------------------------------|
| Ifthenpay v1.3.0 a v1.6.3 | Não compatível | Compatível                     |

# Instalação

Pode instalar o módulo pela primeira vez na sua plataforma Prestashop ou apenas atualizar este.

* Para instalar pela primeira vez, ir à página [Github](https://github.com/ifthenpay/prestashop) do módulo e clicar na última "release";
![img](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/en/release.png)
</br>

* Descarregar o instalador zip com nome "ifthenpay.zip";
![img](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/en/release_download.png)
</br>

* Ou se está a atualizar, descarregar no Prestashop em Módulos/Ifthenpay/Configurar;
![img](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/pt/upgrade_download.png)
</br>

* Ir a Module Manager;
![img](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/pt/module_manager.png)
</br>

* Clicar em "Enviar um módulo";
![img](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/pt/click_upload_module.png)
</br>

* Arrastar o instalador zip para a caixa "Enviar um módulo";
![img](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/pt/drag_upload_module.png)
</br>




# Configuração
## Chave Backoffice
* Após a instalação clicar no botão "Configurar";
![img](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/pt/click_configure.png)
</br>

* Inserir a Chave Backoffice e salvar:
1. A Chave Backoffice é dada na conclusão do contrato e é constituída para conjuntos de quatro algarismos separados por um traço (-), inserir esta no campo "Chave de acesso ao backoffice;
2. Clicar no botão "Salvar";
![img](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/pt/insert_backoffice_key.png)
</br>

## Ativar método de pagamento
Os seguintes passos usam o Multibanco como exemplo, mas o processo é o mesmo para os restantes métodos de pagamento

* Para ativar, siga os passos indicados:
1. (opcional) Ativar esta opção se estiver a testar os métodos de pagamento, isto evita a ativação do callback;
2. Ative o método de pagamento ao mudar o "Estado" para Ativado;
3. Clicar no botão "Salvar";
![img](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/pt/enable_multibanco.png)
</br>

## Multibanco

* Clicar no botão " GERIR" abaixo de Multibanco para configurar o método de pagamento Multibanco;
![img](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/pt/manage_multibanco.png)
</br>

* Configurar o método de pagamento Multibanco:
1. Ativar Callback. Ao selecionar esta opção, o estado da encomenda será atualizado quando o pagamento for recebido;
2. Selecionar uma Entidade. Apenas pode selecionar uma das Entidades associadas à Chave Backoffice;
3. Selecionar uma Sub-Entidade. Apenas pode selecionar uma das Sub-Entidades associadas à Entidade escolhida anteriormente;
4. (opcional) Inserir valor mínimo de encomenda. Apenas exibe este método de pagamento para encomendas com valor superior ao valor inserido;
5. (opcional) Inserir valor máximo de encomenda. Apenas exibe este método de pagamento para encomendas com valor inferior ao valor inserido;
6. (opcional) Selecione um ou mais países. Apenas exibe este método de pagamento para encomendas com destino de envio dentro dos países selecionados, deixar vazio para permitir todos os países;
7. (opcional) Inserir um número de sequência. Ordena os métodos de pagamento na página de checkout de forma ascendente. Número mais baixo toma o primeiro lugar;
8. Clicar no botão "Salvar";
![img](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/pt/config_multibanco.png)
</br>

* Se selecionou "Callback" ativado anteriormente, após salvar, o estado do Callback será mostrado abaixo com a Chave Anti-Phishing e Url de Callback criados;
![img](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/pt/multibanco_callback_activated.png)
</br>

## Multibanco com Referências dinâmicas

O método de pagamento Multibanco com Referências Dinâmicas, gera referências por pedido e é usado se desejar atribuir um tempo limite (em dias) para encomendas pagas com Multibanco.

* Configurar Multibanco com Referências Dinâmicas:
1. No campo Entidade, selecionar "MB", esta entidade só estará disponível para seleção se tiver efetuado contrato para criação de conta Multibanco com Referências Dinâmicas;
2. Selecionar uma Sub-Entidade.
3. (opcional) Selecionar o número de dias de validade.
4. (opcional) Ativar Cancelar Encomenda Multibanco. Ao selecionar esta opção, encomendas Multibanco que ainda não receberam pagamento antes da Validade terminar serão canceladas;
![img](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/pt/config_multibanco_dynamic.png)
</br>



## MB WAY

* Clicar no botão "GERIR" abaixo de MB WAY;
![img](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/pt/manage_mbway.png)
</br>

* Configurar método de pagamento MB WAY:
1. Ativar Callback. Ao selecionar esta opção, o estado da encomenda será atualizado quando o pagamento for recebido;
2. (opcional) Ativar Cancelar Encomenda MB WAY. Ao selecionar esta opção, encomendas MB WAY que ainda não receberam pagamento serão canceladas 30 minutos após a confirmação no checkout;
3. Contador MB WAY, está ativo por defeito. Esta opção determina se o contador MB WAY de 4 minutos é ou não exibido após a confirmação da encomenda;  
4. Selecionar uma Chave MB WAY. Apenas pode selecionar uma das Chaves MB WAY associadas à Chave Backoffice;
5. (opcional) Inserir valor mínimo de encomenda. Apenas exibe este método de pagamento para encomendas com valor superior ao valor inserido;
6. (opcional) Inserir valor máximo de encomenda. Apenas exibe este método de pagamento para encomendas com valor inferior ao valor inserido;
7. (opcional) Selecione um ou mais países. Apenas exibe este método de pagamento para encomendas com destino de envio dentro dos países selecionados, deixar vazio para permitir todos os países;
8. (opcional) Inserir um número de sequência. Ordena os métodos de pagamento na página de checkout de forma ascendente. Número mais baixo toma o primeiro lugar;
9. Clicar no botão "Salvar";
![img](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/pt/config_mbway.png)
</br>

* Se selecionou "Callback" ativado anteriormente, após salvar, o estado do Callback será mostrado abaixo com a Chave Anti-Phishing e Url de Callback criados;
![img](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/pt/mbway_callback_activated.png)
</br>




## Cartão de Crédito

* Clicar no botão "GERIR" abaixo de Cartão de Crédito;
![img](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/pt/manage_ccard.png)
</br>

* Configurar método de pagamento Cartão de Crédito:
1. Selecionar uma Chave CCard. Apenas pode selecionar uma das Chaves CCard associadas à Chave Backoffice;
2. (opcional) Ativar Cancelar Encomenda Ccard. Ao selecionar esta opção, encomendas Ccard que ainda não receberam pagamento serão canceladas 30 minutos após a confirmação no checkout;
3. (opcional) Inserir valor mínimo de encomenda. Apenas exibe este método de pagamento para encomendas com valor superior ao valor inserido;
4. (opcional) Inserir valor máximo de encomenda. Apenas exibe este método de pagamento para encomendas com valor inferior ao valor inserido;
5. (opcional) Selecione um ou mais países. Apenas exibe este método de pagamento para encomendas com destino de envio dentro dos países selecionados, deixar vazio para permitir todos os países;
6. (opcional) Inserir um número de sequência. Ordena os métodos de pagamento na página de checkout de forma ascendente. Número mais baixo toma o primeiro lugar;
7. Clicar no botão "Salvar";
![img](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/pt/config_ccard.png)
</br>


## Payshop

* Clicar no botão "GERIR" abaixo de Payshop;
![img](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/pt/manage_payshop.png)
</br>

* Configurar o método de pagamento Payshop:
1. Ativar Callback. Ao selecionar esta opção, o estado da encomenda será atualizado quando o pagamento for recebido;
2. Selecionar uma Chave Payshop. Apenas pode selecionar uma das Chaves Payshop associadas à Chave Backoffice;
3. (opcional) Inserir Validade para o pagamento. De 1 a 99 dias, deixe vazio não pretender que expire; 
4. (optional) Ativar Cancelar Encomenda Payshop. Ao selecionar esta opção, encomendas Payshop que ainda não receberam pagamento após a Validade serão canceladas;
5. (opcional) Inserir valor mínimo de encomenda. Apenas exibe este método de pagamento para encomendas com valor superior ao valor inserido;
6. (opcional) Inserir valor máximo de encomenda. Apenas exibe este método de pagamento para encomendas com valor inferior ao valor inserido;
7. (opcional) Selecione um ou mais países. Apenas exibe este método de pagamento para encomendas com destino de envio dentro dos países selecionados, deixar vazio para permitir todos os países;
8. (opcional) Inserir um número de sequência. Ordena os métodos de pagamento na página de checkout de forma ascendente. Número mais baixo toma o primeiro lugar;
9. Clicar no botão "Salvar";

![img](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/pt/config_payshop.png)
</br>

* Se selecionou "Callback" ativado anteriormente, após salvar, o estado do Callback será mostrado abaixo com a Chave Anti-Phishing e Url de Callback criados;
![img](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/pt/payshop_callback_activated.png)
</br>


## Cofidis Pay

* Clicar no botão "GERIR" abaixo de Cofidis Pay;
![img](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/pt/manage_cofidis.png)
</br>

* Configurar o método de pagamento Cofidis Pay:
1. Ativar Callback. Ao selecionar esta opção, o estado da encomenda será atualizado quando o pagamento for recebido;
2. Selecionar uma Chave Cofidis Pay. Apenas pode selecionar uma das Chaves Cofidis Pay associadas à Chave Backoffice;
3. (optional) Ativar Cancelar Encomenda Cofidis Pay. Ao selecionar esta opção, encomendas Cofidis Pay expiradas serão canceladas 60 minutos após a confirmação no checkout;
4. (opcional) Inserir valor mínimo de encomenda. Apenas exibe este método de pagamento para encomendas com valor superior ao valor inserido. **Aviso Importante:** Na seleção da chave Cofidis, este campo é atualizado com o valor configurado no backoffice da ifthenpay, e ao editar, este não pode ser inferior ao valor especificado no backoffice da ifthenpay;
5. (opcional) Inserir valor máximo de encomenda. Apenas exibe este método de pagamento para encomendas com valor inferior ao valor inserido. **Aviso Importante:** Na seleção da chave Cofidis, este campo é atualizado com o valor configurado no backoffice da ifthenpay, e ao editar, este não pode ser superior ao valor especificado no backoffice da ifthenpay
6. (opcional) Selecione um ou mais países. Apenas exibe este método de pagamento para encomendas com destino de envio dentro dos países selecionados, deixar vazio para permitir todos os países;
7. (opcional) Inserir um número de sequência. Ordena os métodos de pagamento na página de checkout de forma ascendente. Número mais baixo toma o primeiro lugar;
8. Clicar no botão "Salvar";
![img](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/pt/config_cofidis.png)
</br>

* Se selecionou "Callback" ativado anteriormente, após salvar, o estado do Callback será mostrado abaixo com a Chave Anti-Phishing e Url de Callback criados;
![img](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/pt/cofidis_callback_activated.png)
</br>


## Pix

* Clicar no botão "GERIR" abaixo de Pix;
![img](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/pt/manage_pix.png)
</br>

* Configurar método de pagamento Pix:
1. Ativar Callback. Ao selecionar esta opção, o estado da encomenda será atualizado quando o pagamento for recebido;
2. Selecionar uma Chave Pix. Apenas pode selecionar uma das Chaves Pix associadas à Chave Backoffice;
3. (opcional) Ativar Cancelar Encomenda Ccard. Ao selecionar esta opção, encomendas Ccard que ainda não receberam pagamento serão canceladas 30 minutos após a confirmação no checkout;
4. (opcional) Inserir valor mínimo de encomenda. Apenas exibe este método de pagamento para encomendas com valor superior ao valor inserido;
5. (opcional) Inserir valor máximo de encomenda. Apenas exibe este método de pagamento para encomendas com valor inferior ao valor inserido;
6. (opcional) Selecione um ou mais países. Apenas exibe este método de pagamento para encomendas com destino de envio dentro dos países selecionados, deixar vazio para permitir todos os países;
7. (opcional) Inserir um número de sequência. Ordena os métodos de pagamento na página de checkout de forma ascendente. Número mais baixo toma o primeiro lugar;
8. Clicar no botão "Salvar";
![img](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/pt/config_pix.png)
</br>

* Se selecionou "Callback" ativado anteriormente, após salvar, o estado do Callback será mostrado abaixo com a Chave Anti-Phishing e Url de Callback criados;
![img](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/pt/pix_callback_activated.png)
</br>


## Ifthenpay Gateway

* Clicar no botão "GERIR" abaixo de Ifthenpay Gateway;
![img](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/pt/manage_ifthenpaygateway.png)
</br>

* Configurar o método de pagamento Ifthenpay Gateway:
1. Ativar Callback. Ao selecionar esta opção, o estado da encomenda será atualizado quando o pagamento for recebido;
2. Selecionar uma Chave Ifthenpay Gateway. Apenas pode selecionar uma das Chaves Ifthenpay Gateway associadas à Chave Backoffice;
3. Selecionar uma conta por cada método de pagamento e colocar o visto na checkbox dos métodos que pretende exibir na página de gateway;
4. Selecionar um método de pagamento que estará selecionado por defeito na página da gateway quando o consumidor aceder a esta;
5. (opcional) Selecionar o número de dias de validade da referência Payshop. De 1 a 99 dias, deixe vazio se não pretender que expire;
6. (opcional) Texto exíbido no botão de "Voltar para loja" na página da gateway;
7. (optional) Ativar Cancelar Encomenda Ifthenpay Gateway. Ao selecionar esta opção, encomendas Ifthenpay Gateway que ainda não receberam pagamento após a Validade serão canceladas;
8. (opcional) Inserir valor mínimo de encomenda. Apenas exibe este método de pagamento para encomendas com valor superior ao valor inserido;
9. (opcional) Inserir valor máximo de encomenda. Apenas exibe este método de pagamento para encomendas com valor inferior ao valor inserido;
10. (opcional) Selecione um ou mais países. Apenas exibe este método de pagamento para encomendas com destino de envio dentro dos países selecionados, deixar vazio para permitir todos os países;
11. (opcional) Inserir um número de sequência. Ordena os métodos de pagamento na página de checkout de forma ascendente. Número mais baixo toma o primeiro lugar;
12. (opcional) Exibe o logo deste método de pagamento no checkout, escolha uma de três opções:
    - habilitado - imagem por defeito: Exibe o logo ifthenpay gateway;
    - desabilitado: Exibe o Título do método de pagamento;
    - habilitado - imagem composta: Exibe uma imagem composta por todos os logos dos métodos de pagamento selecionados;
13. The title that appears to the consumer during checkout.
14. Clicar no botão "Salvar";

![img](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/pt/config_ifthenpaygateway.png)
</br>

* Se selecionou "Callback" ativado anteriormente, após salvar, o estado do Callback será mostrado abaixo com a Chave Anti-Phishing e Url de Callback criados;
![img](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/pt/ifthenpaygateway_callback_activated.png)
</br>


# Editar Dados de Pagamento
**Nota importante:** Não é possível mudar ou atualizar para o método de pagamento de Cartão de Crédito.
Na página de detalhes de uma encomenda, é possível editar o método de pagamento e os dados de pagamento.
Um caso de uso para isto seria o seguinte:
  - Um consumidor encomenda 2 unidades de um produto, mas decide que apenas quer um;
  - O consumidor contacta o admin da loja e pede a alteração;
  - O admin da loja edita a quantidade do produto e no fundo da página clica no botão "Atualizar Dados Multibanco/MB WAY/Payshop" e de seguida clica em "Reenviar Dados de Pagamento".

## Atualizar Dados de Pagamento

  * Após alterar a encomenda, clicar no botão "Atualizar Dados Multibanco";
![img](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/pt/update_payment_data.png)
</br>


## Reenviar Dados de Pagamento

  * Após atualizar os dados de pagamento, tem de reenviar os detalhes de pagamento para o consumidor que efetuou a encomenda, clicando no botão "Reenviar Dados de Pagamento";
![img](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/pt/resend_payment_data.png)
</br>
  

## Relembrar Dados de Pagamento
  
  * Se quiser relembrar o consumidor de uma encomenda com pagamento pendente, clique no botão "Relembrar Detalhes de Pagamento";
![img](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/pt/remember_payment_details.png)
</br>

## Escolher Método de Pagamento

Escolher outro método de pagamento:

  * Clicar no botão "Escolher Novo Método de Pagamento";
  ![img](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/pt/choose_payment_method.png)
</br>

  * Selecionar novo método de pagamento dos disponíveis no "dropdown" que acabou de aparecer (1), e clicar em "Alterar Método de Pagamento" (2);
  ![img](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/pt/select_payment_method.png)
</br>

  * Os detalhes de pagamento serão atualizados com o novo método de pagamento, agora deve clicar no botão "Reenviar Dados de Pagamento" para notificar o consumidor da alteração;
  ![img](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/pt/new_payment_method.png)
</br>

  * Se está a mudar de Multibanco ou Payshop para MB WAY, precisa de inserir o número de telemóvel do consumidor e clicar no botão "Alterar Método de Pagamento". Esta ação envia notificação MB WAY automaticamente, mas pode usar o botão " Reenviar Dados de Pagamento" se o consumidor não pagou dentro dos 4 minutos de tempo limite e necessita de outra notificação para a app MB WAY;
    ![img](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/pt/change_to_mbway_payment.png)
</br>



# Outros

## Suporte

* Em Módulos/Ifthenpay/Configurar clicar no botão "Ir para Suporte!" para ser redirecionado para a página de helpdesk de Ifthenpay;
![img](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/pt/support.png)
</br>

## Pedir Conta

* Se ainda não tem conta Ifthenpay, pode pedir uma preenchendo o ficheiro pdf do contrato de adesão que pode descarregar clicando no botão "Criar Conta!", e enviando este juntamente com os documentos pedidos para o email ifthenpay@ifthenpay.com 
![img](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/pt/request_account.png)
</br>


## Requerer criação de conta adicional

Se já tem uma conta Ifthenpay, mas não tem contratou um método de pagamento que agora precisa, pode fazer um pedido automático para a Ifthenpay;

* Em Módulos/Ifthenpay/Configurar, haverá um botão "REQUERER A CRIAÇÃO DE CONTA ..." para cada método de pagamento que ainda não tenha contratado. Clique no botão do método de pagamento de necessita. Assim que a equipa da Ifthenpay adiciona o método de pagamento à sua conta, a lista de métodos de pagamento disponíveis no seu módulo será atualizada com o novo.
![img](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/pt/request_account_creation.png)


## Logs

* Pode consultar os logs relativos ao módulo em Módulos/Ifthenpay/Configurar, clicando na tab "LOGS";
![img](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/pt/click_logs.png)
</br>

* Os logs registam erros e outros eventos que podem ajudar a detetar a fonte de um problema;
![img](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/pt/logs.png)
</br>

## Reset de Configuração

* Se adquiriu uma nova Chave Backoffice e pretende atribuí-la ao seu site, mas já tem uma atualmente atribuída, pode efetuar o reset da configuração do módulo. Em Módulos/Ifthenpay/Configurar, clique no botão "Reinicializar".
**Atenção, esta ação irá limpar as atuais configurações do módulo**;
![img](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/pt/reset.png)
</br>

* Após reinicializar, ser-lhe-á mais uma vez pedido para inserir a Chave Backoffice;
![img](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/pt/backoffice_key.png)
</br>

## Atualizações

* Em Módulos/Ifthenpay/Configurar, no fim da página é possível verificar se existem atualizações disponíveis para o módulo;
![img](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/pt/update.png)
</br>

## Modo Sandbox

* Para fazer testes antes de colocar a sua loja em produção, deve mudar o "Modo Sandbox" para Ativado e clicar no botão "Salvar", antes de ativar o Callback dos métodos de pagamento.
O Modo Sandbox é usado para impedir a ativação do Callback e a comunicação entre o servidor da Ifthenpay e a sua loja.
![img](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/pt/sandbox_mode.png)
</br>

## Callback

* O Callback é uma funcionalidade que quando ativa, permite que a sua loja receba a notificação de um pagamento bem-sucedido. Quando ativa, ao receber um pagamento com sucesso de uma encomenda, o servidor da ifthenpay comunica com a sua loja, mudando o estado da encomenda para "PAGO" ou "Em Processamento" (o nome do estado dependerá das configurações do seu Prestashop). Pode usar os pagamentos da Ifthenpay sem ativar o Callback, mas as suas encomendas não atualizaram o estado automaticamente;

* Estados de Callback:
1. Callback inativo (a encomenda não muda de estado quando recebe o pagamento);
![img](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/pt/callback_status_disabled.png)
</br>

2. Callback ativo (a encomenda muda de estado quando recebe o pagamento);
![img](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/pt/callback_status_activated.png)
</br>

3. Callback ativo e Modo Sandbox ativo (a encomenda não muda de estado quando recebe o pagamento);
![img](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/pt/callback_status_sandbox.png)
</br>

## Testar Callback

Em cada página de configuração de um método de pagamento (excepto Cartão de Crédito), pode testar a funcionalidade do Callback clicando no botão "Testar Callback". Esta ação irá simular um pagamento bem-sucedido para uma encomenda na sua loja, alterando o estado da mesma. Necessita que o Callback esteja ativo.

**Multibanco:** Use os dados seguintes (1) e (2) dos detalhes de pagamento de encomenda:
![img](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/pt/multibanco_callback_data.png)
</br>

para preencher o formulário de Testar Callback e clicar no botão "Testar Callback" (3):
![img](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/pt/multibanco_callback_test.png)
</br>
</br>

**MB WAY:** Use os dados seguintes (1) e (2) dos detalhes de pagamento de encomenda:

![img](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/pt/mbway_callback_data.png)
</br>

para preencher o formulário de Testar Callback e clicar no botão "Testar Callback" (3):
![img](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/pt/mbway_callback_test.png)
</br>
</br>

**Payshop:** Use os dados seguintes (1) e (2) dos detalhes de pagamento de encomenda:
![img](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/pt/payshop_callback_data.png)
</br>

para preencher o formulário de Testar Callback e clicar no botão "Testar Callback" (3):
![img](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/pt/payshop_callback_test.png)
</br>
</br>

**Cofidis:** Use os dados seguintes (1) e (2) dos detalhes de pagamento de encomenda:

![img](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/pt/cofidis_callback_data.png)
</br>

para preencher o formulário de Testar Callback e clicar no botão "Testar Callback" (3):
![img](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/pt/cofidis_callback_test.png)
</br>

**Pix:** Use os dados seguintes (1) e (2) dos detalhes de pagamento de encomenda:

![img](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/pt/pix_callback_data.png)
</br>

para preencher o formulário de Testar Callback e clicar no botão "Testar Callback" (3):
![img](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/pt/pix_callback_test.png)
</br>

**Ifthenpay Gateway**: No backoffice, use o ID de encomenda e o valor e introduza este nos respetivos campos (1) e (2) do formulário de teste de callback e clique em Testar (3).
![img](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/pt/ifthenpaygateway_callback_test.png)

</br>




## Bugs conhecidos e soluções

* Em algumas versões do prestashop, habilitar o ccc (Combinar, Comprimir e Cache) para javascript, resultará em erros de minimização.
Para reparar esta situação, substitua a pasta "js" pela pasta "js_uglyfied".
1. Altere o nome da pasta "js" para "js_minimized".
2. Altere o nome da pasta "js_uglyfied" para "js".

![img](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/en/ccc_fix.png)
</br>


# Experiência do Utilizador Consumidor
As ações seguintes são descritas da perspetiva do cliente consumidor.
## Pagar encomenda com Multibanco

* Selecionar Multibanco no checkout e confirmar encomenda:
1. Selecionar "Pagamento por Multibanco";
2. Colocar o visto nos "termos do serviço" (Depende da sua configuração do Prestashop);
3. Clicar no botão "PLACE ORDER";
![img](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/pt/checkout_multibanco.png)
</br>

* Após a confirmação, será redirecionado para a página de resumo de encomenda onde estarão exibidos os dados para pagamento por Multibanco
![img](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/pt/multibanco_payment_return.png)
</br>

## Pagar encomenda com Payshop

* Selecionar Payshop no checkout e confirmar encomenda:
1. Selecionar "Pagamento por Payshop";
2. Colocar o visto nos "termos do serviço" (Depende da sua configuração do Prestashop);
3. Clicar no botão "PLACE ORDER";
![img](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/pt/checkout_payshop.png)
</br>

* Após a confirmação, será redirecionado para a página de resumo de encomenda onde estarão exibidos os dados para pagamento por Payshop;
![img](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/pt/payshop_payment_return.png)
</br>

## Pagar encomenda com MB WAY

* Selecionar MB WAY no checkout e confirmar encomenda:
1. Selecionar "Pagamento por MB WAY";
2. Inserir o número de um smartphone com a app do MB WAY instalada; 
3. Colocar o visto nos "termos do serviço" (Depende da sua configuração do Prestashop);
4. Clicar no botão "PLACE ORDER";

![img](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/pt/checkout_mbway.png)
</br>

* Após a confirmação, será redirecionado para a página de resumo de encomenda onde estarão exibidos o contador MB WAY e os dados de pagamento por MB WAY;
1. Contador MB WAY;
2. Informação de pagamento MB WAY;
![img](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/pt/mbway_payment_return.png)
</br>

* Durante a contagem decrescente, as interações do utilizador com a app MB WAY atualizaram o contador com mensagem de informação:
1. se aceitou o pagamento na app MB WAY, o contador irá atualizar com "Encomenda Paga!";
![img](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/pt/mbway_payment_paid.png)
</br>

2. se rejeitou o pagamento na app MB WAY, o contador irá atualizar com "Pagamento Recusado!";
![img](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/pt/mbway_payment_refused.png)
</br>

3. se no checkout inseriu um número de telemóvel que não possui a app MB WAY instalada, ou existe uma falha nas comunicações com os servidores da SIBS nesse momento, o contador irá atualizar com "Pagamento MB WAY falhou!";
![img](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/pt/mbway_payment_error.png)
</br>

* terminou o tempo, pode reenviar uma notificação MB WAY clicando no botão "REENVIAR NOTIFICAÇÃO MB WAY";
![img](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/pt/mbway_payment_notification_resend.png)
</br>

## Pagar encomenda com Credit Card

* Selecionar Cartão de Crédito e confirmar encomenda:
1. Selecionar "Pagamento por Cartão de Crédito";
2. Colocar o visto nos "termos do serviço" (Depende da sua configuração do Prestashop);
3. Clicar no botão "PLACE ORDER";
![img](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/pt/checkout_ccard.png)
</br>

* Preencher dados do cartão de crédito:
1. Inserir Número do Cartão;
2. Inserir Data de Validade;
3. Inserir CVV/CVC;
4. Inserir Nome no Cartão;
5. Clicar no botão "PAGAR";
![img](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/pt/ccard_payment.png)
</br>

* Após pagar, será redirecionado de volta para a loja,
![img](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/pt/ccard_payment_return.png)
</br>


## Pagar encomenda com Cofidis Pay

* Selecionar Cofidis Pay e confirmar encomenda:
1. Selecionar "Pagamento por Cofidis Pay";
2. Colocar o visto nos "termos do serviço" (Depende da sua configuração do Prestashop);
3. Clicar no botão "PLACE ORDER";
![img](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/pt/checkout_cofidis.png)
</br>

* Entre ou, se não tiver conta faça o registo com Cofidis Pay:
1. Clique "Avançar" para registar em Cofidis Pay;
2. Ou se tiver uma conta Cofidis Pay, preencha as suas credencias de acesso e clique entrar;
![img](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/pt/cofidis_payment_1.png)
</br>

* Número de prestações, faturação e dados pessoais:
1. Selecione o número de prestações que deseja;
2. Verifique o sumário do plano de pagamento;
3. Preencha os seus dados pessoais e de faturação;
4. Clique em "Avançar" para continuar;
![img](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/pt/cofidis_payment_2.png)
</br>

* Termos e condições:
1. Selecione "Li e autorizo" para concordar com os termos e condições;
2. Clique em "Avançar"
![img](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/pt/cofidis_payment_3.png)
</br>

* Formalização do acordo:
1. Clique em "Enviar código";
![img](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/pt/cofidis_payment_4.png)
</br>

* Código de autenticação da formalização do acordo:
1. Preencha o com o código que recebeu no telemóvel;
1. Clique em "Confirmar código";
![img](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/pt/cofidis_payment_5.png)
</br>

* Resumo e Pagamento:
1. Preencha com os detalhes do seu cartão de crédito(número, data de expiração e CW), e clique em "Validar";
![img](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/pt/cofidis_payment_6.png)
</br>

* Sucesso e voltar à loja:
1. Clique no icone para voltar à loja;
![img](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/pt/cofidis_payment_7.png)
</br>

* Após o qual será redirecionado de volta para a loja;
![img](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/pt/cofidis_payment_return.png)
</br>


## Pagar encomenda com Pix

* Selecionar Pix e confirmar encomenda:
1. Selecionar "Pagamento por Pix";
2. Preencher of formulário. Apenas o Nome, CPF e Email são obrigatórios, os restantes campos são opcionais;
3. Colocar o visto nos "termos do serviço" (Depende da sua configuração do Prestashop);
4. Clicar no botão "PLACE ORDER";
![img](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/pt/checkout_pix.png)
</br>

* Proceder com o pagamento de duas formas:
1. Ler o código QR com o smartphone;
2. Copiar o código Pix e pagar com online banking;
**Nota Importante:** De modo a ser redirecionado de volta para a loja após o pagamento, esta página deve permanecer aberta. Se fechada, o consumidor ainda pode proceder ao pagamento desde que já tenha lido o código Pix, apenas não será redirecionado de volta para a loja.
![img](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/pt/pix_payment.png)
</br>

* Após pagar, será redirecionado de volta para a loja,
![img](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/pt/pix_payment_return.png)
</br>


## Pagar encomenda com Ifthenpay Gateway

* Selecionar Cartão de Crédito e confirmar encomenda:
1. Selecionar "Pagamento por Cartão de Crédito";
2. Colocar o visto nos "termos do serviço" (Depende da sua configuração do Prestashop);
3. Clicar no botão "PLACE ORDER";
![img](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/pt/checkout_ifthenpaygateway.png)
</br>

Selecionar um dos métodos de pagamento disponíveis na página da gateway (1).
![img](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/pt/ifthenpaygateway_payment_1.png)
</br>

No caso do método de pagamento Multibanco, a entidade, referência e valor serão exibidos.
Aqui o consumidor pode fazer uma das duas ações:
 - em caso de método de pagamento offline, guardar os dados de pagamento, clicar em fechar a gateway no botão (2) e pagar mais tarde;
 - pagar no momento e clicar no botão de confirmar pagamento (3) para verificar o pagamento; 
![img](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/pt/ifthenpaygateway_payment_2.png)
</br>

Se o consumidor não pagou no momento e não guardou os dados de pagamento, ainda pode aceder mais tarde a estes através do link de acesso à gateway encontrado no histórico de encomenda na conta de utilizador ou email de confirmação de encomenda. 
![img](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/pt/ifthenpaygateway_payment_3.png)
</br>

Chegou ao fim do manual da extensão ifthenpay para Prestashop 1.7.
