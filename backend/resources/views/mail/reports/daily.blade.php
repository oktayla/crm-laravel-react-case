<x-mail::message>
# Daily Business Report

Hello,

We've prepared your daily business insights for {{ $today->toDateString() }}.

<x-mail::table>
| Metric | Value |
|:-------|------:|
| New Customers | {{ $reportData['new_customers'] }} |
| Total Orders | {{ $reportData['total_orders'] }} |
| Total Revenue | ${{ number_format($reportData['total_revenue'], 2) }} |
| Average Order Value | ${{ number_format($reportData['average_order_value'], 2) }} |
</x-mail::table>

</x-mail::message>
