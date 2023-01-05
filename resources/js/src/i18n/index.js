import { createI18n } from 'vue-i18n'

const i18n = createI18n({
  locale: 'br',
  messages: {
    br: {
      AppTitle: 'Panelas',
      home: {
        title: 'Lista de empresas',
        table: {
          title: {
            name: 'Nome',
            description: 'Descrição',
            uf: 'UF',
            city: 'Cidade',
            email: 'email',
            phone: 'Telefone'
          }
        }
      }
    },
  },
});

export default i18n;