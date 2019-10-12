<template>
  <q-expansion-item
    :header-inset-level="-0.5"
    :content-inset-level="0.5"
    group="client"
    default-closed
    header-class="text-primary"
    switch-toggle-side
            
    v-show="!isDeleted()"
    :to="{name: 'client-show', params: { id: client.id }}" 
    class="bg-white">
    <template v-slot:header>
      <q-item-section>
        <q-item-label 
            v-html="$options.filters.searchHighlight(client.full_name, search)"
            :style="client.deleted ? 'text-decoration:line-through' : ''">
          </q-item-label>
          <q-item-label
            v-html="$options.filters.searchHighlight(client.einssa, search)"
            caption
            lines="1"
            :style="client.deleted ? 'text-decoration:line-through' : ''">
          </q-item-label>
      </q-item-section>

      <q-item-section avatar>
        <q-icon :color="client.client_status.icon_color" :name="client.client_status.icon_name" />
      </q-item-section>
    </template>

    <q-card class="bg-white">
      <q-list class="text-primary">
        <q-item clickable>
          <q-item-section avatar>  
            <q-icon color="primary" name="face" />          
          </q-item-section>

          <q-separator />

          <q-item-section>
            <q-item-label caption>{{ client.client_type.id == 1 ? 'Nome' : 'Razao Social' }}</q-item-label>
            <q-item-label>{{ client.full_name }}</q-item-label>
          </q-item-section>
        </q-item>

        <q-item clickable>
          <q-item-section avatar>
            <q-icon color="primary" name="face" /> 
          </q-item-section>

          <q-item-section>
            <q-item-label caption>{{ client.client_type.id == 1 ? 'Apelido' : 'Fantasia' }}</q-item-label>
            <q-item-label>{{ client.name }}</q-item-label>
          </q-item-section>
        </q-item>

        <q-item clickable>
          <q-item-section avatar>
            <q-icon color="primary" name="fingerprint" />
          </q-item-section>

          <q-item-section>
            <q-item-label caption>{{ client.client_type.id == 1 ? 'CPF' : 'CNPJ' }}</q-item-label>
            <q-item-label>{{ client.einssa }}</q-item-label>
          </q-item-section>
        </q-item>

        <q-item clickable>
          <q-item-section avatar>
            <q-icon color="primary" name="smartphone" />
          </q-item-section>

          <q-item-section>
            <q-item-label caption>Celular</q-item-label>
            <q-item-label>{{ client.mobile }}</q-item-label>
          </q-item-section>
        </q-item>

        <q-item clickable>
          <q-item-section avatar>
            <q-icon color="primary" name="phone" />
          </q-item-section>

          <q-item-section>
            <q-item-label caption>Telefone</q-item-label>
            <q-item-label>{{ client.phone }}</q-item-label>
          </q-item-section>
        </q-item>
        
        <q-item clickable>
          <q-item-section avatar>
            <q-icon color="primary" name="email" />
          </q-item-section>

          <q-item-section>
            <q-item-label caption>E-mail</q-item-label>
            <q-item-label>{{ client.email }}</q-item-label>
          </q-item-section>
        </q-item>

        <q-item clickable>
          <q-item-section avatar>
            <q-icon color="primary" name="fingerprint" />
          </q-item-section>

          <q-item-section>
            <q-item-label caption>Tipo</q-item-label>
            <q-item-label>{{ client.client_type.description }}</q-item-label>
          </q-item-section>
        </q-item>

        <q-item clickable>
          <q-item-section avatar>
            <q-icon color="primary" name="how_to_reg" />
          </q-item-section>

          <q-item-section>
            <q-item-label caption>Situacao</q-item-label>
            <q-item-label>{{ client.client_status.description }}</q-item-label>
          </q-item-section>
        </q-item>
      </q-list>
    </q-card>
  </q-expansion-item>
</template>

<script>
  import { mapState, mapActions } from 'vuex'
  export default {
    data() {
      return {
      }
    },
    props: [
      'client',
      'id',
      'index'
    ],
    filters: {
      searchHighlight(value, search) {
        // console.log('value: ', value)
        // console.log('search: ', search)
        if (search) {
          let searchRegExp = new RegExp(search, 'i')
          return value.replace(searchRegExp, (match) => {
            return "<span class='bg-yellow-6'>" + match + "</span>"
          })
        }
        return value
      }
    },
    computed: {
      ...mapState('clients', ['search'])
    },
    methods: {
      isDeleted() {
        return this.client.deleted
      }
      //show() {
      //  this.$router.push(
      //    {
      //      name: 'client-show', 
      //      params: { 
      //        id: client.id 
      //      }
      //    }
      //  )
      //}
    }
  }
</script>

<style>

</style>


