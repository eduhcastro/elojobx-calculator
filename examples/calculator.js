var fila = "solo/duo";

function getPrecoServico(data) {
    var cupom_ativo = 1;
    var cupom_nome = "Jobx";
    var cupom_desconto = 20;
    var base_img = '/Template/imagens/badges/';
    var elosSemDivisao = ["mestre", "grao-mestre", "desafiante"];
    var ligaatual = $('#ligaatual').val();
    var divisaoatual = $('#divisaoatual').val();
    var ligadesejada = $('#ligadesejada').val();
    var divisaodesejada = $('#divisaodesejada').val();
    var ligaatual_ = $('#ligaatual option:selected').text();
    var divisaoatual_ = $('#divisaoatual option:selected').text();
    var ligadesejada_ = $('#ligadesejada option:selected').text();
    var divisaodesejada_ = $('#divisaodesejada option:selected').text();
    if (elosSemDivisao.includes(ligaatual)) {
        var nomeEloAtual = ligaatual_;
        var currentImage = ligaatual + '.png';
        $('#divisaoatual').hide();
    } else {
        var nomeEloAtual = ligaatual_ + ' ' + divisaoatual_;
        var currentImage = ligaatual + '_' + divisaoatual + '.png';
        $('#divisaoatual').show();
    }
    if (elosSemDivisao.includes(ligadesejada)) {
        var nomeEloDesejado = ligadesejada_;
        var desiredImage = ligadesejada + '.png';
        $('#divisaodesejada').hide();
    } else {
        var nomeEloDesejado = ligadesejada_ + ' ' + divisaodesejada_;
        var desiredImage = ligadesejada + '_' + divisaodesejada + '.png';
        $('#divisaodesejada').show();
    }
    $('#current-image').attr('src', base_img + currentImage);
    $('#desired-image').attr('src', base_img + desiredImage);
    $.ajax({
        //url: 'https://elojobhigh.com.br/app/servico_preco.json',
        url: 'http://localhost/api/calculate-booster',
        type: 'POST',
        dataType: 'json',
        data: { atualelo: ligaatual, atualdivisao: divisaoatual, deseelo: ligadesejada, desedivisao: divisaodesejada, Fila: fila, servico: 'eloboost' },
        beforeSend: function () {
            $('#resultado').html('<div class="col-sm text-center text-white"><img src="/Template/imagens/preload.png" alt="carregando..." width="55" style="margin: 0 auto;" /></div>');
        },
        success: function (data) {
            if (data.status) {
                if (cupom_ativo) {
                    var valor_desconto = formatMoneyUS(data.Value) - (formatMoneyUS(data.Value) / 100 * cupom_desconto);
                    var html = '<div class="col"><p class="price-old">DE: R$ ' + data.Value + '</p>';
                    html += '<p class="price">R$ ' + formatMoneyBR(valor_desconto) + '</p>';
                    html += '<p class="cupom">' + cupom_desconto + '% de desconto com o cupom <strong>' + cupom_nome + '</strong> + inÃ­cio imediato</p></div>';
                } else {
                    var html = '<div class="col price">R$ ' + data.Value + '</div>';
                }

                html += '<div class="col d-flex text-right">';
                html += '<form method="POST" action=' + data.Url + ' id="contratar" hidden>'
                for (var prop in data) {
                    if (data.hasOwnProperty(prop)) {
                        html += `<input type="hidden" name="${prop}" value="${data[prop]}">`;
                    }
                }
                html += '<input type="hidden" name="fila" value="' + fila + '">'
                html += '</form>'
                html += '	 <a href="javascript:{}" onclick="document.getElementById(\'contratar\').submit();" id="comprar" class="button-3" href="' + data.Url + '">CONTRATAR</a>';
                html += '</div>';
            } else {
                var html = '<div class="alert alert-danger" role="alert">' + data.Mensagem + '</div>';
            }
            $('#resultado').html(html);
        }
    });
}

function fila(id) {
    alert(id);
    return false;
}
$(function () {
    $('#ligaatual, #ligadesejada, #divisaoatual, #divisaodesejada').change(function () {
        $('#form-service').submit();
    });
    $('.fila').click(function () {
        var fila_tmp = $(this).data('value').toLowerCase();
        fila = fila_tmp;
        if (fila_tmp == "solo/duo") {
            $('#fila-flex').removeClass('active');
            $('#fila-soloduo').addClass('active');
        } else {
            $('#fila-soloduo').removeClass('active');
            $('#fila-flex').addClass('active');
        }
        $('#form-service').submit();
    });
    $('#form-service').submit(function () {
        getPrecoServico($(this).serialize());
        return false;
    }).submit();
});