<template>
	<div class="q-pa-md">
	<q-layout view="lHh lpr lFf" class=" rounded-borders">
		<q-header bordered class="bg-white text-primary">
			<q-toolbar>
				<q-toolbar-title class="text-center">
				<q-avatar>
					<img src="https://cdn.quasar.dev/logo-v2/svg/logo.svg">
				</q-avatar>
				App Compras
				</q-toolbar-title>
			</q-toolbar>
		</q-header>

		<q-footer bordered class="bg-white text-primary">
			<q-tabs no-caps active-color="primary" indicator-color="transparent" class="text-grey" v-model="tab">
				<q-route-tab
					icon="la la-list"
					to="/lista"
					label="Lista"
					exact
				/>

				<q-route-tab
					icon="la la-dollar"
					to="/comprar"
					label="Comprar"
					exact
				/>

				<q-route-tab
					icon="la la-history"
					to="/historico"
					label="Histórico"
					exact
				/>
			</q-tabs>
		</q-footer>
		<q-page-container>
			<router-view />
		</q-page-container>
	</q-layout>
  </div>
</template>
<script>
import { ref } from 'vue'

export default {
  setup () {
    return {
      tab: ref('images')
    }
  }
}
</script>