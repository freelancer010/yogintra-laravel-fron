<div class="table-responsive">
  <table class="table table-bordered">
    <tr>
      <td class="text-center font-16 font-weight-600 bg-theme-colored2 text-white" colspan="6">Prices For All Student</td>
    </tr>
    <tr>
      <th>Ticket</th>
      <th>Price</th>
      <th>Capacity</th>
      <th>Default Qty</th>
      <th>Reserve Qty</th>
    </tr>
    <tbody>
      @if($event->Indian_stu_checkbox == 1)
      <tr>
        <td>{{ $event->ticket_indian }}</td>
        <td>&#x20B9;{{ $event->ticket_price_indian }}</td>
        <td>{{ $event->ticket_capacity_indian }}</td>
        <td>{{ $event->ticket_d_qnty_indian }}</td>
        <td>{{ $event->ticket_r_qnty_indian }}</td>
      </tr>
      @endif
      @if($event->Foreign_stu_checkbox == 1)
      <tr>
        <td>{{ $event->ticket_foreigner }}</td>
        <td>&#x20B9;{{ $event->ticket_price_foreigner }}</td>
        <td>{{ $event->ticket_capacity_foreigner }}</td>
        <td>{{ $event->ticket_d_qnty_foreigner }}</td>
        <td>{{ $event->ticket_r_qnty_foreigner }}</td>
      </tr>
      @endif
    </tbody>
  </table>
</div>