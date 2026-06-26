# Bikcraft

Site para uma loja de bicicletas elétricas desenvolvido usando HTML, CSS, JavaScript e PHP.

## 💻️ Tecnologias

- HTML
- CSS
- JavaScript
- PHP

## ⚙️ Como usar

### 1. Clone o repositório

```bash
git clone https://github.com/elainefs/origamid.git

# Acesse a pasta do projeto
cd origamid
```

### 2. Crie um arquivo `.env` na raiz do projeto

O arquivo `.env-example` é um modelo de como o seu arquivo `.env` deve ser.

Adicione as suas credencias do servidor SMTP para que seja feito o envio de E-mails através dos formulários presentes no site.

### 3. Configure o PHP e o Apache 

Você precisa ter o PHP e o Apache configurados para o envio dos E-mails.

Instale o [XAMPP](https://elaineferreira.com.br/instalar-e-configurar-o-xampp-no-debian), depois siga os seguintes passos.

#### 3.1. Abra o arquivo `/opt/lampp/etc/httpd.conf` 

Procure pelo trecho abaixo e descomente o Include:

```bash
# Virtual hosts
Include etc/extra/httpd-vhosts.conf
```

#### 3.2. Depois abra o arquivo `/opt/lampp/etc/extra/httpd-vhosts.conf` 

Nesse arquivo adicione um virtual host para o projeto.

```bash
<VirtualHost *:80>
    ServerAdmin webmaster@bikcraft.localhost
    DocumentRoot "/home/user/bikcraft/" # Mude para o caminho do projeto baixado no passo 1
    ServerName bikcraft.localhost
    ErrorLog "logs/bikcraft.localhost"
    CustomLog "logs/bikcraft.localhost" common
    <Directory "/home/user/bikcraft/"> # Mude para o caminho do projeto baixado no passo 1
	AllowOverride AuthConfig Limit
    	Require all granted
    	ErrorDocument 403 /error/XAMPP_FORBIDDEN.html.var
    </Directory>
</VirtualHost>
```

Para projetos fora do `/opt/lampp/htdocs/` é preciso mudar as permissões para que o Apache consiga ler a pasta do projeto.

```bash
sudo chmod o+X /home/user/pasta-do-projeto
sudo chown -R $USER:www-data /home/user/pasta-do-projeto
sudo chmod -R u+rwX,go+rX /home/user/pasta-do-projeto
```

Por fim adicione o mesmo nome do virtual host no arquivo `/etc/hosts` do sistema.

```bash
127.0.1.1	bikcraft.localhost
```

Reinicie o Apache para que as alterações tenha efeito.

Depois basta acessar o projeto através da URL definida no `ServerName`.

```bash
http://bikcraft.localhost
``` 

## 📄 Licença

Este projeto está sobre a licença MIT. Veja o arquivo LICENSE para mais informações.

Made with ❤️ by Elaine Ferreira
