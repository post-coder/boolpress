<html>
  <head>
    
  </head>

  <body>
    
    <h1>Hai ricevuto una richiesta di contenuto</h1>

    <table>
      <thead>
        <th>Nome</th>
        <th>Email</th>
      </thead>

      <tbody>
        <tr>
          <td>{{$lead->name}}</td>
          <td>{{$lead->email}}</td>
        </tr>
      </tbody>
    </table>

    <h4>Testo del messaggio:</h4>
    <p>
      {{$lead->content}}
    </p>
    

  </body>
</html>