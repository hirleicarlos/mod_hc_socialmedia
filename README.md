# mod_hc_socialmedia

Módulo Joomla 4 / 5 / 6 para gerenciamento profissional de links de redes sociais com múltiplos layouts e personalização individual via CSS Variables.

---

## 📦 Versão Atual

**1.0.0**

Primeira versão estável com:

- Arquitetura moderna (Dispatcher + HelperFactory)
- 5 layouts independentes
- Estrutura limpa e organizada
- Personalização individual por item
- Compatível com Joomla 4.x, 5.x e 6.x
- Compatível com PHP 8+

---

## 🚀 Próxima Versão

**1.1.0 (Planejada)**

- Estrutura nativa para botão WhatsApp
- Campo específico para número + mensagem pré-definida
- Integração opcional com layout destacado
- Melhorias de acessibilidade

---

## 🏗 Arquitetura do Projeto

Estrutura baseada no padrão moderno de módulos Joomla:

```
mod_hc_socialmedia/
│
├── mod_hc_socialmedia.xml
├── services/
│   └── provider.php
│
├── src/
│   ├── Dispatcher/
│   │   └── Dispatcher.php
│   │
│   └── Helper/
│       └── SocialmediaHelper.php
│
├── tmpl/
│   ├── default.php
│   ├── minimal.php
│   ├── inline.php
│   ├── boxed.php
│   └── stacked.php
│
└── media/
    └── css/
        ├── default.css
        ├── minimal.css
        ├── inline.css
        ├── boxed.css
        └── stacked.css
```

---

## 🧠 Padrão de Projeto

- Dispatcher responsável apenas por preparar dados
- Helper responsável por processamento e normalização
- Layouts responsáveis apenas por renderização
- CSS modular por layout
- Uso de CSS Variables para customização individual

### Separação de responsabilidades

| Camada      | Responsabilidade |
|-------------|------------------|
| Dispatcher  | Entregar dados ao layout |
| Helper      | Processar e validar dados |
| Layout      | Renderização HTML |
| CSS         | Estilização isolada por layout |

---

## 🎨 Layouts Disponíveis

1. **default** — Padrão institucional
2. **minimal** — Ultra clean
3. **inline** — Linha horizontal com separadores
4. **boxed** — Cards clicáveis
5. **stacked** — Tiles verticais (ícone acima / texto abaixo)

---

## 🎛 Personalização Individual

Cada item pode receber variáveis CSS próprias:

```
--hc-bg
--hc-text
--hc-border
--hc-bg-hover
--hc-text-hover
--hc-border-hover
--hc-border-width
--hc-radius
--hc-py
--hc-px
--hc-shadow
--hc-transition
```

Aplicadas automaticamente quando `use_custom = 1`.

---

## 🛡 Boas Práticas Aplicadas

- Compatível com Joomla 4–6
- Arquitetura DI (Dependency Injection)
- Sanitização básica de dados
- Fail-safe (módulo não derruba o site)
- Código organizado por responsabilidade
- Preparado para evolução sem breaking change

---

## 📌 Requisitos

- Joomla 4.4+
- PHP 8.0+
- Navegador moderno com suporte a CSS Variables

---

## 🔧 Instalação

1. Compacte o diretório `mod_hc_socialmedia`
2. Instale via Extensões → Instalar
3. Publique o módulo
4. Configure os itens no painel administrativo

---

## 👨‍💻 Autor

**Hirlei Carlos Pereira de Araújo**

🌐 Site: https://hirleicarlos.github.io/  
📧 Email: prof.hirleicarlos@gmail.com

---

## 📄 Licença

GNU General Public License version 2 or later.

---

## 📈 Roadmap

- [ ] Estrutura WhatsApp dedicada
- [ ] Integração opcional com SVG oficial WhatsApp
- [ ] Melhorias de acessibilidade ARIA
- [ ] Estrutura para presets de cores
- [ ] Possível integração futura com API externa

---

## 💡 Filosofia do Projeto

Este módulo foi desenvolvido com foco em:

- Arquitetura limpa
- Evolução controlada por versão
- Organização de código profissional
- Facilidade de manutenção
- Compatibilidade futura

---

## 🤝 Contribuição

Sugestões, melhorias e contribuições são bem-vindas.

---

## ⭐ Status

Projeto ativo e em evolução.