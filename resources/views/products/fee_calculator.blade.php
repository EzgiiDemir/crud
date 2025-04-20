@extends('layouts.app')

@section('content')
    <select id="country">
        <option value="">Ülke Seçin</option>
        {{-- JS ile doldurulacak --}}
    </select>

    <select id="term">
        <option value="">Yıl Seçin</option>
    </select>

    <button id="calculate">Hesapla</button>

    <div id="result"></div>

    <script>
        axios.get('/api/countries').then(res => {
            res.data.forEach(c => {
                document.querySelector('#country')
                    .insertAdjacentHTML('beforeend',
                        `<option value="${c.id}">${c.definition}</option>`);
            });
        });

        document.querySelector('#country').addEventListener('change', e => {
            axios.get('/api/terms', { params: { country_id: e.target.value } })
                .then(res => {
                    const sel = document.querySelector('#term');
                    sel.innerHTML = '<option>Yıl Seçin</option>';
                    res.data.forEach(t => {
                        sel.insertAdjacentHTML('beforeend',
                            `<option value="${t.id}">${t.definition}</option>`);
                    });
                });
        });

        // Benzer şekilde sonraki adımlar…
        document.querySelector('#calculate').addEventListener('click', () => {
            const payload = {
                country_id:  document.querySelector('#country').value,
                term_id:     document.querySelector('#term').value,
                // diğer seçimler…
            };
            axios.post('/api/calculate', payload)
                .then(res => {
                    document.querySelector('#result').innerText = JSON.stringify(res.data, null, 2);
                });
        });
    </script>

@endsection
