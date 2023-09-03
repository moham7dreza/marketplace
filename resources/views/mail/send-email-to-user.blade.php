@component('mail::message', ['class' => 'dir-rtl'])
    <section>
        <h1 style="text-align: center;">{{ $this->details['subject'] }}</h1>
        <p style="text-align: justify;direction: rtl;color: black;">{{ strip_tags($this->details['body']) }}</p>
    </section>
    <section style="display: flex;align-items: center;justify-content: space-between;">
        <h4 style="direction: rtl"></h4>
        <a style="text-decoration: none;font-weight: bolder;color: red;border: 1px solid wheat;padding: 1rem;border-radius: 1rem;"
           href="/">فروشگاه</a>
    </section>

@endcomponent
