<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header row">
            <div class="col-md-2">
              {{ $t('home.title') }}
            </div>
          </div>

          <div class="card-body">
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th>{{ $t('home.table.title.name') }}</th>
                  <th>{{ $t('home.table.title.description') }}</th>
                  <th>{{ $t('home.table.title.uf') }}</th>
                  <th>{{ $t('home.table.title.city') }}</th>
                  <th>{{ $t('home.table.title.email') }}</th>
                  <th>{{ $t('home.table.title.phone') }}</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="company in companies">
                  <td>{{ company.name }}</td>
                  <td>{{ company.description.substring(0, 50) }}...</td>
                  <td>{{ company.UF }}</td>
                  <td>{{ company.city }}</td>
                  <td @click="showMailForm(company.mail)">{{ company.email }}
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                      class="bi bi-envelope" viewBox="0 0 16 16">
                      <path
                        d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4Zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1H2Zm13 2.383-4.708 2.825L15 11.105V5.383Zm-.034 6.876-5.64-3.471L8 9.583l-1.326-.795-5.64 3.47A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.741ZM1 11.105l4.708-2.897L1 5.383v5.722Z" />
                    </svg>
                  </td>
                  <td>
                    <a href="https://wa.me/{{ company.phone }}">
                      {{ company.phone }}
                    </a>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  data() {
    return {
      companies: {},
      UF: {},
      selected: {
        UF: '',
        city: ''
      },
      cities: {},
    }
  },
  async mounted() {
    console.log('oi');
  },

}
</script>
<style>
.row {
  margin-right: 0 !important;
  margin-left: 0 !important;
}
</style>