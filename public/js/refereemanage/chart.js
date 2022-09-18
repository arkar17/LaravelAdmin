$(document).ready(function(){
    const labels1 = [
        '23',
        '45',
        '66',
        '00',
        '76',
        '38',
        '38',
        '38',
        '38',
        '38',
      ];
    const labels2 = [
        '*3',
        '4*',
        '6*',
        '*0',
        '7*',
        '8*',
        '*8',
        '9*',
        '9*',
        '0*',
      ];

      const data1 = {
        labels: labels1,
        datasets: [{
          label: 'Amount',
          backgroundColor: '#EB5E28',
          borderColor: 'rgb(255, 99, 132)',
          data: [1000, 2000, 3000, 4000, 5000,1500,1450,2300],
        }]
      };
      const data2 = {
        labels: labels2,
        datasets: [{
          label: 'Amount',
          backgroundColor: '#EB5E28',
          borderColor: 'rgb(255, 99, 132)',
          data: [1000, 2000, 3000, 4000, 5000,1500,1450,2300],
        }]
      };

      const config1 = {
        type: 'bar',
        data: data1,
        options: {}
      };
      const config2 = {
        type: 'bar',
        data: data2,
        options: {}
      };

      const twodChart = new Chart(
        document.getElementById('2dchart'),
        config1
      );
      const lonepyineChart = new Chart(
        document.getElementById('lonepyinechart'),
        config2
      );

})
