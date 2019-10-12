<template>
  <q-drawer
      v-model="leftDrawerOpen"
      bordered
      content-class="bg-grey-2"
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

        <q-separator spaced />

        <q-item>
          <q-item-section avatar top>
            <q-avatar>
              <img src="~assets/img/users/1.jpg" />
            </q-avatar>
          </q-item-section>

          <q-item-section
            v-if="getAuthUserLoggedIn()">
            <q-item-label lines="1">{{ getAuthUser().name }}</q-item-label>
            <q-item-label caption>{{ getAuthUser().email }}</q-item-label>
          </q-item-section>

           <q-item-section
            v-else>
            <q-item-label lines="1">Anonimo</q-item-label>
            <q-item-label caption></q-item-label>
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
        <q-separator spaced />

        <q-item clickable tag="a" target="_blank" href="https://quasar.dev">
          <q-item-section avatar>
            <q-icon name="school" />
          </q-item-section>
          <q-item-section>
            <q-item-label>Docs</q-item-label>
            <q-item-label caption>quasar.dev</q-item-label>
          </q-item-section>
        </q-item>
      </q-list>

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
</template>

<script>
  import { mapActions, mapGetters } from 'vuex'

  export default {
    data () {
      return {
        // leftDrawerOpen: this.$q.platform.is.desktop,
        leftDrawerOpen: false
      }
    },
    methods: {
      ...mapActions('auth', ['actAuthClear']),
      ...mapGetters('auth', ['getAuthUserLoggedIn']),
      ...mapGetters('auth', ['getAuthUserPage']),
      ...mapGetters('auth', ['getAuthUser']),
      logout() {
        this.actAuthClear()
        this.$router.push('/about')
      },
      login() {
        this.$router.push('/auth')
      }
    }
  }
</script>

<style>
</style>
