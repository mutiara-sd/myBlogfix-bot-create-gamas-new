<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">      
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0 font-size-18">{{ $title }}</h4>
                        </div>
                        <livewire:assurance.bot.bot-create-gamas />
                    </div>
                </div>
            </div>  
        </div>
    </div>
</x-layout>