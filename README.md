## Escopo Projeto Integrador 

  Utilizamos frequentemente diversas plataformas e ferramentas de reprodução de áudio. Observamos através do uso delas, que não existe uma ferramenta que o usuário possa adicionar suas próprias músicas e organizá-las da forma que mais o agrada.

  Percebemos que, com a criação de uma ferramenta para unir ambas funcionalidades, de reprodução e principalmente do armazenamento de arquivos próprios de áudio, os usuários poderiam acessar suas próprias playlists em qualquer lugar e em qualquer dispositivo com acesso a internet.

  O  projeto visa armazenar e reproduzir músicas, onde o usuário poderá fazer upload de seus áudios, organizá-los em playlist, compartilhá-las e curtir playlist de outros usuários.

## Requisitos Projeto Integrador 

Este projeto abrangerá os seguintes requisitos:

- CRUD de usuarios;
- CRUD de áudios;
- CRUD de playlist;
- Reprodutor de arquivo de áudio;
    - Reproduzir;
    - Aleatoriedade;
    - Avançar/Retroceder;
    - Repetir;
- Recuperação de senhas de usuários;
- Compartilhamento de Playlist;
    - Público;
    - Privado;
    - Privado, com compartilhamento com outra(s) conta(s) com autorização;
- Curtir playlist;
- Listagem playlist pública (Comunidade);



Tecnologia Projeto Integrador 

Para o desenvolvimento deste projeto, serão utilizados as seguintes tecnologias e ferramentas:

- Livewire
- Laravel
- PHP
- MySql
- Nginx
- Github Actions
- Jira
- Figma
- Linux


## Requisitos Funcionais

| Código   | Requisito Funcional  | Caso de Uso  |
|---|---|---|
| RF 01  | O sistema deve gerenciar os dados dos usuários no sistema. Deverá conter as funções confirmar e-mail, cadastrar, editar e consultar usuário. O usuário irá se auto-cadastrar.  | UC 01 - Gerenciar Usuário   |
| RF 02  | O sistema deve gerenciar os áudios que os usuários registrarem na plataforma. Através desta funcionalidade, o usuário poderá adicionar, deletar, editar e buscar áudios. <br><br>Um registro de áudio será composto por um arquivo de áudio a ser salvo em um repositório de arquivos.| UC 02 - Gerenciar Áudios  |
| RF 03  | O sistema irá gerenciar as playlists que os usuários criarem. Ele deverá criar, deletar, editar e buscar playlists.<br><br>Uma  playlist será composta por áudios previamente cadastrados.<br><br>A playlist poderá ser privada (acessada apenas pelo usuário que a criou) ou pública (acessada por qualquer usuário). | UC 03 - Gerenciar Playlist  |
| RF 04  | O sistema deverá permitir que o usuário curta áudios   | UC 04 - Curtir Áudio  |
| RF 05  | O sistema deve permitir ao usuário curtir playlists.  | UC 05 - O sistema deve permitir ao usuário curtir playlists.  |
| RF 06  | O sistema irá gerenciar o player, reproduzindo, pausando, avançando e retrocedendo, parando e aleatorizando a execução dos áudios.  | UC 06 - Reproduzir Áudio  |
| RF 07  | O sistema deverá permitir o compartilhamento de playlists com outros usuários especificados.  | UC - 07 - Compartilhar Playlists  |
| RF 08  | O sistema deve gerenciar o login de acesso à plataforma, permitindo logar, recuperar senha e fazer logout.  | UC 08 - Gerenciar Acesso  |


## Imagem DER

![image der](https://drive.google.com/uc?id=1LMLLHZEM-z-QbKreWGGDtPjS5acn5Ld-)


## Imagem Use Case

![image use case](https://drive.google.com/uc?id=1Qge2HpD9hEhUC3afSUG2u9O5hoVMvBjH)

## Link Protótipo

https://www.figma.com/file/YEWwQfRJnsnllnBvG5mY1w/PFC-WEB?type=design&node-id=0%3A1&mode=design&t=USgyE2t4a1h18xJP-1