<template>
  <q-layout 
    view="lHh Lpr lFf"
    style="background: radial-gradient(circle, #35a2ff 0%, #014a88 100%)">
    <q-header elevated>
      <q-toolbar
        class="bg-primary glossy text-white">
        <q-btn
          v-if="getAuthUserLoggedIn()"
          flat
          dense
          round
          @click="leftDrawerOpen = !leftDrawerOpen"
          aria-label="Menu"
        >
          <q-icon>
            <img src="~assets/img/logo-light-icon.png">
          </q-icon>
        </q-btn>
        
        <q-toolbar-title 
          v-show="companyIn()">
            {{ companyIn().name }}
        </q-toolbar-title>

        <q-space />
        
        <q-btn-dropdown 
          v-if="getAuthUserLoggedIn()"
          flat>
          <template v-slot:label>
            <div class="row">
              <q-avatar size="auto">
                <img src="~assets/img/users/1.jpg">
              </q-avatar>
            </div>
          </template>
          <q-list>
            <q-item-label header>{{ getAuthUser().name }}</q-item-label>
            <q-item v-for="n in 3" :key="`x.${n}`" clickable v-close-popup tabindex="0">
              <q-item-section avatar>
                <q-avatar icon="folder" color="secondary" text-color="white" />
              </q-item-section>
              <q-item-section>
                <q-item-label>Photos</q-item-label>
                <q-item-label caption>February 22, 2016</q-item-label>
              </q-item-section>
              <q-item-section side>
                <q-icon name="info" />
              </q-item-section>
            </q-item>
            <q-separator inset spaced />
            <q-item-label header>Files</q-item-label>
            <q-item v-for="n in 3" :key="`y.${n}`" clickable v-close-popup tabindex="0">
              <q-item-section avatar>
                <q-avatar icon="assignment" color="primary" text-color="white" />
              </q-item-section>
              <q-item-section>
                <q-item-label>Vacation</q-item-label>
                <q-item-label caption>February 22, 2016</q-item-label>
              </q-item-section>
              <q-item-section side>
                <q-icon name="info" />
              </q-item-section>
            </q-item>
          </q-list>
        </q-btn-dropdown>

        <q-btn 
          v-if="!getAuthUserLoggedIn()"
          to="/auth"
          flat
          icon-right="account_circle" 
          class="absolute-right" />

          
      </q-toolbar>
    </q-header>

    <q-drawer
      v-model="leftDrawerOpen"
      show-if-above
      :width="280"
      :breakpoint="500"
      bordered
      content-class="bg-grey-3"
    >
      <q-list>
        <q-item>
          <q-item-section>
            <q-item-label overline class="full-height full-width text-center">
              <img src="~assets/img/logo-icon.png" />
              <br>
              <img src="~assets/img/logo-text.png" />
            </q-item-label>
          </q-item-section>
        </q-item>

        <q-item>
          <q-item-section>
            <q-img class="absolute-top" src="https://cdn.quasar.dev/img/material.png" 
              style="height: 110px">
              <div class="absolute-bottom bg-transparent">
                <q-avatar size="40px" class="q-mb-xs">
                  <img src="https://cdn.quasar.dev/img/boy-avatar.png">
                </q-avatar>
                <div class="text-weight-bold">{{ getAuthUser().name }}</div>
                <div>{{ getAuthUser().email }}</div>
              </div>
            </q-img>
          </q-item-section>

          <q-item-section side>
            <q-btn
                round
                size="sm"
                color="negative"
                @click="logout"
                icon="exit_to_app"
              />
          </q-item-section>
        </q-item>

        <q-separator spaced />
        <q-item-label header>Menu</q-item-label>
        
        <div class="q-pa-md">
          <q-btn-dropdown
            split
            color="orange"
            push
            glossy
            no-caps
            icon="folder"
            label="Selecione sua Empresa">
            <q-list>
              <q-item clickable v-close-popup>
                <q-item-section avatar>
                  <q-avatar icon="folder" color="primary" text-color="white" />
                </q-item-section>
                <q-item-section>
                  <q-item-label>Photos</q-item-label>
                  <q-item-label caption>February 22, 2016</q-item-label>
                </q-item-section>
                <q-item-section side>
                  <q-icon name="info" color="amber" />
                </q-item-section>
              </q-item>

              <q-item clickable v-close-popup>
                <q-item-section avatar>
                  <q-avatar icon="assignment" color="secondary" text-color="white" />
                </q-item-section>
                <q-item-section>
                  <q-item-label>Vacation</q-item-label>
                  <q-item-label caption>February 22, 2016</q-item-label>
                </q-item-section>
                <q-item-section side>
                  <q-icon name="info" color="amber" />
                </q-item-section>
              </q-item>
            </q-list>
          </q-btn-dropdown>
        </div>
        
      </q-list>

      <q-scroll-area class="fit">
          <q-list v-for="(menuItem, index) in menuList" :key="index">

            <q-item clickable :active="menuItem.label === 'Outbox'" :to="menuItem.to">
              <q-item-section avatar>
                <q-icon :name="menuItem.icon" />
              </q-item-section>
              <q-item-section>
                {{ menuItem.label }}
              </q-item-section>
            </q-item>

           <q-separator v-if="menuItem.separator" />

          </q-list>
        </q-scroll-area>

      <div class="fixed-bottom text-center light text-italic absolute">
        Powered by
        <a href="#"><img src="#" alt=""></a>
        <a href="#"><img src="#" alt=""></a>
        <div class="q-pa-sm">
          <q-btn-group push>
            <div class="row">
              <div class="col">
                <q-btn color="yellow" glossy text-color="black" push label="" icon="verified_user" />
              </div>
              <div class="col">
                <q-btn color="amber" glossy text-color="black" push label="" icon="verified_user" />
              </div>
              <div class="col">
                <q-btn color="orange" glossy text-color="black" push label="" icon="verified_user" />
              </div>
            </div>
          </q-btn-group>
        </div>
      </div>
    </q-drawer>

    <q-page-container>
      <div class="q-pa-xs">
        <vue-status>
          <div slot="offline">
            <q-banner dense class="bg-grey-3">
              <template v-slot:avatar>
                <q-icon name="signal_wifi_off" color="primary" />
              </template>
              Verifique sua conexao com a Internet.
            </q-banner>
          </div>

          <div slot="online">
            <router-view />
          </div>
        </vue-status>
      </div>      
    </q-page-container>
  </q-layout>
</template>

<script>
  import { mapActions, mapGetters, mapState } from 'vuex'
  import { SessionStorage } from 'quasar'
  import VueStatus from 'vue-status'

  const menuList = [
  {
    icon: 'people',
    label: 'Clientes',
    to: '/user/clients',
    separator: true
  },
  {
    icon: 'send',
    label: 'Outbox',
    separator: false
  },
  {
    icon: 'settings',
    label: 'Settings',
    separator: false
  },
  {
    icon: 'feedback',
    label: 'Send Feedback',
    separator: false
  },
  {
    icon: 'help',
    iconColor: 'primary',
    label: 'Help',
    separator: false
  }
]
export default {
    data () {
      return {
        // leftDrawerOpen: this.$q.platform.is.desktop,
        leftDrawerOpen: false,
        menuList
      }
    },
    methods: {
      ...mapActions('auth', ['actAuthClear']),
      ...mapGetters('auth', ['getAuthUserLoggedIn']),
      ...mapGetters('auth', ['getAuthUser']),
      ...mapState('auth', ['companyIn']),
      logout() {
        SessionStorage.set('loggedIn', false)
        this.actAuthClear()
        this.$router.push('/about');
      }
    },
    components: {
      VueStatus
    }
  }
</script>

<style>
</style>
