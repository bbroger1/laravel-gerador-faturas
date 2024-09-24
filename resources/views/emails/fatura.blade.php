@component('mail::message')
# Olá, {{ $dados['cliente']['nome'] }}!

Sua fatura está na situação: **{{ $dados['situacao'] }}**  
Mensagem: "Agradecemos pela sua compra! Se precisar de ajuda, entre em contato."

## Dados da Empresa:

- **Nome:** {{ $dados['empresa']['nome'] }}
- **Endereço:** {{ $dados['empresa']['endereco'] }}
- **E-mail:** {{ $dados['empresa']['email'] }}
- **Telefone:** {{ $dados['empresa']['telefone'] }}

Obrigado por escolher nossos serviços!

@component('mail::footer')
{{ $dados['empresa']['nome'] }}<br>
{{ $dados['empresa']['endereco'] }}<br>
E-mail: {{ $dados['empresa']['email'] }} | Telefone: {{ $dados['empresa']['telefone'] }}
@endcomponent
@endcomponent
