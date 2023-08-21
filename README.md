# PhpThoughts
<p align="center">

<a href="https://github.com/GrowBit-Tech/PhpThoughts"><img src="https://img.shields.io/github/issues/GrowBit-Tech/PhpThoughts" alt="Issues"></a>
<a href="https://github.com/GrowBit-Tech/PhpThoughts"><img src="https://img.shields.io/github/stars/GrowBit-Tech/PhpThoughts" alt="Stars"></a>
<a href="https://github.com/GrowBit-Tech/PhpThoughts"><img src="https://img.shields.io/github/license/GrowBit-Tech/PhpThoughts" alt="License"></a>
<a href="https://github.com/GrowBit-Tech/PhpThoughts"><img src="https://img.shields.io/github/contributors/GrowBit-Tech/PhpThoughts" alt="Contributors"></a>
</p>

## About PhpThoughts

PhpThoughts is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable, creative experience to be truly fulfilling. PhpThoughts attempts to take the pain out of development by easing common tasks used in the majority of web projects, such as:

- Simple, fast attribute based routing engine.
- Powerful [dependency injection](https://php-di.org/) container (PSR-11).
- [Doctrine](https://www.doctrine-project.org/projects/doctrine-orm/en/2.16/index.html) database ORM.
- [Socket server and client](http://socketo.me/).
- Powerful CLI.
- Based on onion architecture.
- HTTP message interfaces (PSR-7).
- HTTP Server Request Handlers, Middleware (PSR-15).
- Autoloader (PSR-4).
- Logger (PSR-3).
- Code styles (PSR-12).
- Single action controllers.
- [Input validation](https://github.com/rakit/validation).
- Console Commands.
- Swager (Auto Generate).

PhpThoughts is accessible, yet powerful, providing tools needed for large, robust applications. A superb combination of simplicity, elegance, and innovation gives you a complete toolset required to build any application with which you are tasked.

## Learning PhpThoughts
### Create new project

> composer create-project grow-bit-tech/php-thoughts [ProjectName]
### Directory structure
Directory structure: [https://medium.com/@rizwan3d/my-next-project-directory-structure-of-php-2f589466602a](https://medium.com/@rizwan3d/my-next-project-directory-structure-of-php-2f589466602a)

### CLI
#### Run project
> php ./brain --serve --host localhost --port 8080

> **Default** host = localhost and port = 8080
#### Run socket
> php ./brain --socket

#### Update Framework
> php ./brain --update

#### Create Database Schema
> php ./brain --db --create

#### Update Framework
> php ./brain --db --update


## Other Pkg
- [vaibhavpandeyvpz/doctrine-datatables](https://vaibhavpandey.com/doctrine-datatables/)
- [slim/http-cache](https://github.com/slimphp/Slim-HttpCache)
- [guzzlehttp/guzzle](https://docs.guzzlephp.org/en/stable/)

## Contributing

Thank you for considering contributing to the PhpThoughts framework! The contribution guide can be found [here](LICENSE.md).

## License

The PhpThoughts framework is open-sourced software licensed under the [MIT license](LICENSE.md).