<script>
    $(document).ready(function() {

        $('.select2').select2();

        var agents = @json($agents);
        var cashin_cashouts = @json($cashin_cashouts);

        console.log(cashin_cashouts);

        $('.inputPhone1').val(agents[0].user.phone);
        $('.inputPhone2').val(agents[0].user.phone);
        $('.inputRemainingAmount1').val(cashin_cashouts[0].remaining_amount == null ? "" : cashin_cashouts[0].remaining_amount);

        $('.inputCoinAmount2').val(cashin_cashouts[0].coin_amount);

        $('.se1').on('change', function() {
            var id = $('.se1').val();
            console.log("Hee Hee");
            agents.forEach(agent => {
                if (agent.id == id) {
                    $('.inputPhone1').val(agent.user.phone);
                }
            });
        });
        // to show remaining amount start
        $('.se1').on('change', function() {
            var id = $('.se1').val();
            agents.forEach(agent => {
                cashin_cashouts.forEach(cashin_cashout => {
                    if (cashin_cashout.agent.id == agent.id) {
                        if (agent.id == id) {
                            $('.inputRemainingAmount1').val(cashin_cashout
                                .remaining_amount);
                        }
                    }
                })
            });
        });
        // to show remaining amount end


        $('.se2').on('change', function() {
            var id = $('.se2').val();
            agents.forEach(agent => {
                if (agent.id == id) {
                    $('.inputPhone2').val(agent.user.phone);
                }
            });
        });

        $('.se2').on('change', function() {
            var id = $('.se2').val();
            agents.forEach(agent => {
                cashin_cashouts.forEach(cashin_cashout => {
                    if (cashin_cashout.agent.id == agent.id) {
                        if (agent.id == id) {
                            $('.inputCoinAmount2').val(cashin_cashout.coin_amount);
                        }
                    }
                })
            });
        });
    });
</script>
