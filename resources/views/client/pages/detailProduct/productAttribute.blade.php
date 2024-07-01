<div class='container' style="background-color: white;padding: 20px;">
    <div>
        <h1 class="title" style="width: 100%; display:flex; font-size: 20px;color: black; text-transform: uppercase;">
            Chi tiết sản
            phẩm</h1>
        <table style="width: 100%; margin-top: 20px;">
            @foreach($detailProduct->Attribute as $index => $attribute)
            <tr style="flex-shrink: 1;">
                <td style="width: 20%; background-color: rgb(239,239,239); padding: 8px; border: none;">
                    {{ $attribute->attribute_name }}</td>
                <td
                    style="width: 80%; padding: 8px; border: none; {{ $index % 2 == 0 ? 'background-color:#F8FAFC;' : 'background-color:white;' }}">
                    {{ $attribute->attribute_description }}</td>
            </tr>
            @endforeach
        </table>
    </div>
</div>