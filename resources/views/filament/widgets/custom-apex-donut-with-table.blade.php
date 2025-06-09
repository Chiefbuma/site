<x-filament::widget>
    <div style="background: #18181b; border-radius: 1rem; padding: 1.5rem; color: #fff;">
        <div>
            {{ $this->chart() }}
        </div>
        <div style="margin-top: 2rem;">
            <table style="width:100%; border-collapse: collapse; color: #fff;">
                <thead>
                    <tr style="background: #27272a;">
                        <th style="text-align:left; padding: 0.5rem;">Label</th>
                        <th style="text-align:right; padding: 0.5rem;">Count</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($this->tableData as $row)
                        <tr style="border-top: 1px solid #27272a;">
                            <td style="padding: 0.5rem;">{{ $row['label'] }}</td>
                            <td style="padding: 0.5rem; text-align:right;">{{ $row['count'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-filament::widget>