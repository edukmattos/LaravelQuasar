<template>
  <div class="q-pa-md q-gutter-sm">
    <q-input
      ref="filter"
      filled
      v-model="filter"
      label="Search - only filters labels that have also '(*)'"
    >
      <template v-slot:append>
        <q-icon v-if="filter !== ''" name="clear" class="cursor-pointer" @click="resetFilter" />
      </template>
    </q-input>

    <q-tree
      :nodes="companySectorsTree"
      node-key="id"
      label-key="description"
      :filter="filter"
      :filter-method="myFilterMethod"
      :expanded.sync="expanded"
      accordion
      default-body="code"
    />
  </div>
</template>

<script>
export default {
  data () {
    return {
      companySectorsTree: [
        {
            "id": 1,
            "_lft": 0,
            "_rgt": 0,
            "parent_id": null,
            "code": "MAN\/G",
            "description": "Ger Man Industrial",
            "created_at": null,
            "updated_at": null,
            "deleted_at": null,
            "children": [
                {
                    "id": 2,
                    "_lft": 0,
                    "_rgt": 0,
                    "parent_id": 1,
                    "code": "MANIND\/C",
                    "description": "Coor Man Industrial",
                    "created_at": null,
                    "updated_at": null,
                    "deleted_at": null,
                    "children": [
                        {
                            "id": 5,
                            "_lft": 0,
                            "_rgt": 0,
                            "parent_id": 2,
                            "code": "EQMEC\/L",
                            "description": "Lider Equipe Mecanica",
                            "created_at": null,
                            "updated_at": null,
                            "deleted_at": null,
                            "children": []
                        },
                        {
                            "id": 6,
                            "_lft": 0,
                            "_rgt": 0,
                            "parent_id": 2,
                            "code": "EQELE\/L",
                            "description": "Lider Equipe Eletrica",
                            "created_at": null,
                            "updated_at": null,
                            "deleted_at": null,
                            "children": []
                        }
                    ]
                },
                {
                    "id": 3,
                    "_lft": 0,
                    "_rgt": 0,
                    "parent_id": 1,
                    "code": "MANEMOV\/C",
                    "description": "Coor Man Equiptos Móveis",
                    "created_at": null,
                    "updated_at": null,
                    "deleted_at": null,
                    "children": []
                },
                {
                    "id": 4,
                    "_lft": 0,
                    "_rgt": 0,
                    "parent_id": 1,
                    "code": "PLANEJAM\/C",
                    "description": "Coor Planej e Programacao",
                    "created_at": null,
                    "updated_at": null,
                    "deleted_at": null,
                    "children": [
                        {
                            "id": 7,
                            "_lft": 0,
                            "_rgt": 0,
                            "parent_id": 4,
                            "code": "EQMEC\/L",
                            "description": "Lider Equipe Mecanica",
                            "created_at": null,
                            "updated_at": null,
                            "deleted_at": null,
                            "children": []
                        },
                        {
                            "id": 8,
                            "_lft": 0,
                            "_rgt": 0,
                            "parent_id": 4,
                            "code": "EQELE\/L",
                            "description": "Lider Equipe Eletrica (*)",
                            "created_at": null,
                            "updated_at": null,
                            "deleted_at": null,
                            "children": []
                        }
                    ]
                }
            ]
        },
        {
            "id": 9,
            "_lft": 0,
            "_rgt": 0,
            "parent_id": null,
            "code": "SUP\/G",
            "description": "Ger Suprimentos",
            "created_at": null,
            "updated_at": null,
            "deleted_at": null,
            "children": [
                {
                    "id": 10,
                    "_lft": 0,
                    "_rgt": 0,
                    "parent_id": 9,
                    "code": "COMP\/C",
                    "description": "Coord Compras",
                    "created_at": null,
                    "updated_at": null,
                    "deleted_at": null,
                    "children": []
                }
            ]
        }
      ],
      filter: 'de',
      expanded: ['Good service (disabled node) (*)']
    }
  },

  methods: {
    myFilterMethod (node, filter) {
      const filt = filter.toLowerCase()
      return node.description && node.description.toLowerCase().indexOf(filt) > -1
    },

    resetFilter () {
      this.filter = ''
      this.$refs.filter.focus()
    }
  }
}
</script>
