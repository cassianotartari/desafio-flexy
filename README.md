# Desafio Flexy

Criar um sistema de cálculo de frete por faixa de CEP + peso do produto. O sistema deve buscar e calcular a opção de menor custo e prazo para entrega de um produto de
determinado peso para um determinado CEP informado.

Esse desafio foi escrito utilizando o framework Symfony 2.8 com Doctrine ORM e Sonata Admin.

## Requisitos

- Ubuntu 64
- Docker CE, instruções de intalação podem ser encontradas [aqui](https://docs.docker.com/engine/installation/linux/docker-ce/ubuntu/#install-using-the-repository).

## Instalação

1. Execute ``git clone https://github.com/cassianotartari/desafio-flexy.git``
2. Execute ``cd desafio-flexy``
3. Execute ``sudo chmod +x install.sh``
4. Execute ``sudo su``
3. Execute como **root** ``# ./install.sh`` na raiz do projeto.
4. Pressione ``ENTER`` quando perguntado para adicionar o repositório.

## Rodando

1. Acesse [http://localhost:8888](http://localhost:8888)

## Descrição de alguns arquivos importantes

```
.
├── app
│   ├── config
│   │   ├── config.yml - basic configuration of the bundles
│   │   ├── parameters.yml - basic parameters, for example: database authentication
│   │   ├── routing.yml - basic routing
├── src
│    └── AppBundle
│        ├── AppBundle.php
│        ├── Controller
│        │   ├── StatsController.php - All endpoints logic related to statistics
│        │   ├── UrlController.php - All endpoints logic related to Urls
│        │   └── UserController.php - All endpoints logic related to User
│        ├── Entity
│        │   ├── Url.php - Url object
│        │   └── User.php - User object
│        ├── Repository
│        │   ├── UrlRepository.php - Url repository queries
│        │   └── UserRepository.php - User repository queries
│        └── Services
│            └── PseudoCryptService.php - Service to generate hashs for shortened urls
└── tests
    └── AppBundle
        └── Controller
            └── ApiControllerTest.php - Basic functional tests
```
