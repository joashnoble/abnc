import Vue from 'vue'
import Router from 'vue-router'

// Containers
import Full from '@/containers/Full'

// Views
import Dashboard from '@/views/Dashboard'
// import Charts from '@/views/Charts'
// import Widgets from '@/views/Widgets'

// Views - Components
// import Buttons from '@/views/components/Buttons'
// import SocialButtons from '@/views/components/SocialButtons'
// import Cards from '@/views/components/Cards'
// import Forms from '@/views/components/Forms'
// import Modals from '@/views/components/Modals'
// import Switches from '@/views/components/Switches'
// import Tables from '@/views/components/Tables'

// Views - Icons
// import FontAwesome from '@/views/icons/FontAwesome'
// import SimpleLineIcons from '@/views/icons/SimpleLineIcons'

// Views - Pages
import Page404 from '@/views/pages/Page404'
import Page500 from '@/views/pages/Page500'
import Login from '@/views/pages/Login'
import Logout from '@/views/pages/Logout'
import Register from '@/views/pages/Register'

//Views - Management
import clients from '@/views/Management/Clients'
import services from '@/views/Management/Services'

//Views - References
import departments from '@/views/references/Departments'
import industries from '@/views/references/Industries'
import categories from '@/views/references/Categories'
import servicetype from '@/views/references/ServiceType'
import servicegrouptype from '@/views/references/ServiceGroupType'

//Views - Content Management
import newspublication from '@/views/cms/NewsPublication'
import seminars from '@/views/cms/Seminars'
import gallery from '@/views/cms/Gallery'
import csr from '@/views/cms/CSR'
import careers from '@/views/cms/careers'
import teams from '@/views/cms/Teams'
import carousels from '@/views/cms/Carousels'

//Views - Archive Management
import archiveservices from '@/views/archives/services'
import ArchiveNewsPublication from '@/views/archives/NewsPublication'

//Views - Utilities
import users from '@/views/utilities/Users'
import profile from '@/views/utilities/Profile'
import usergroups from '@/views/utilities/UserGroups'
import companysettings from '@/views/utilities/CompanySettings'

//Views - Transactions
// import contracts from '@/views/transactions/Contracts'
// import billing from '@/views/transactions/Billing'
// import payment from '@/views/transactions/Payment'
// import adjustment from '@/views/transactions/Adjustment'
// import chargeslip from '@/views/transactions/ChargeSlip'

//Views - Reports
// import soa from '@/views/reports/Soa'
// import ack_receipt from '@/views/reports/AckReceipt'
// import tenant_per_sqm_rate from '@/views/reports/TenantsPerSqmRate'
// import contracts_master_list from '@/views/reports/ContractsMasterList'
// import tenants_master_list from '@/views/reports/TenantsMasterList'
// import billing_forecast from '@/views/reports/BillingForecast'
// import rental_and_charges from '@/views/reports/RentalAndCharges'
// import expiring_contracts from '@/views/reports/ExpiringContracts'
// import new_contracts from '@/views/reports/NewContracts'
// import collectionreport from '@/views/reports/CollectionReport'

//Views - Accounting
// import ar_billing from '@/views/accounting/ArBilling'
// import ar_payment from '@/views/accounting/ArPayment'

import store from '../store'
Vue.use(Router)

const router = new Router({
  mode: 'hash', // Demo is living in GitHub.io, so required!
  linkActiveClass: 'open active',
  scrollBehavior: () => ({ y: 0 }),
  routes: [
    {
      path: '/',
      redirect: 'dashboard',
      name: 'Home',
      component: Full,
      children: [
        {
          path: 'dashboard',
          name: 'Dashboard',
          component: Dashboard,
          meta: { requiresAuth: true },
        },     
        {
          path: 'clients',
          name: 'Clients',
          component: clients,
          meta: { requiresAuth: true },
        },           
        {
          path: 'services',
          name: 'Service Management',
          component: services,
          meta: {requiresAuth: true, rights: '5-17'}
        },      
        {
          path: 'references',
          name: 'References',
          component: {
            render (c) { return c('router-view') }
          },
          children: [
            {
              path: 'departments',
              name: 'Departments',
              component: departments,
              meta: {requiresAuth: true, rights: '1-1'}
            },
            {
              path: 'industries',
              name: 'Industries',
              component: industries,
              meta: {requiresAuth: true, rights: '2-5'}
            },                 
            {
              path: 'categories',
              name: 'Categories',
              component: categories,
              meta: {requiresAuth: true, rights: '3-9'}
            },
            {
              path: 'servicetype',
              name: 'Service Type',
              component: servicetype,
              meta: {requiresAuth: true, rights: '4-13'}
            },   
            {
              path: 'servicegrouptype',
              name: 'Service Group Type',
              component: servicegrouptype,
              meta: {requiresAuth: true, rights: '4-13'}
            }    
          ]
        },
        {
          path: 'cms',
          name: 'Content Management',
          component: {
            render (c) { return c('router-view') }
          },
          children: [
            {
              path: 'newspublication',
              name: 'News Publication',
              component: newspublication,
              meta: {requiresAuth: true, rights: '6-21'}
            },
            {
              path: 'seminars',
              name: 'Seminars',
              component: seminars,
              meta: {requiresAuth: true, rights: '7-25'}
            },  
            {
              path: 'csr',
              name: 'CSR',
              component: csr,
              meta: {requiresAuth: true, rights: '8-29'}
            },     
            {
              path: 'careers',
              name: 'Careers',
              component: careers,
              meta: {requiresAuth: true, rights: '9-33'}
            },
            {
              path: 'gallery',
              name: 'Gallery',
              component: gallery,
              meta: {requiresAuth: true, rights: '10-37'}
            },             
            {
              path: 'teams',
              name: 'Teams',
              component: teams,
              meta: {requiresAuth: true, rights: '11-41'}
            },
            {
              path: 'carousels',
              name: 'Carousel',
              component: carousels,
              meta: {requiresAuth: true, rights: '12-45'}
            }                                    
          ]
        },
        {
          path: 'archives',
          name: 'Archives Management',
          component: {
            render (c) { return c('router-view') }
          },
          children: [
            {
              path: 'services',
              name: 'Services',
              component: archiveservices,
              meta: {requiresAuth: true, rights: '1-1'}
            },
            {
              path: 'NewsPublication',
              name: 'Archive News Publication',
              component: ArchiveNewsPublication,
              meta: {requiresAuth: true, rights: '1-1'}
            }
          ]
        },        
        {
          path: 'accounts',
          name: 'Accounts',
          component: {
            render (c) { return c('router-view') }
          },
          children: [
            {
              path: 'users',
              name: 'Users',
              component: users,
              meta: {requiresAuth: true, rights: '13-49'}
            },
            {
              path: 'profile',
              name: 'Profile',
              component: profile,
              meta: {requiresAuth: true}
            },
            {
              path: 'user_groups',
              name: 'User Groups',
              component: usergroups,
              meta: {requiresAuth: true, rights: '14-53'}
            },
            {
              path: 'company_settings',
              name: 'Company Settings',
              component: companysettings,
              meta: {requiresAuth: true, rights: '15-57'}
            }
          ]
        },
        // {
        //   path: 'reports',
        //   name: 'Reports',
        //   component: {
        //     render (c) { return c('router-view') }
        //   },
        //   children: [
        //     {
        //       path: 'soa',
        //       name: 'Soa',
        //       component: soa,
        //       meta: { requiresAuth: true, rights: '14-54' }
        //     },
        //     {
        //       path: 'ack_receipt',
        //       name: 'Acknowledgement Receipt',
        //       component: ack_receipt,
        //       meta: { requiresAuth: true, rights: '15-58' }
        //     },
        //     {
        //       path: 'tenant_per_sqm_rate',
        //       name: 'Tenant Per Sqm Rate',
        //       component: tenant_per_sqm_rate,
        //       meta: { requiresAuth: true, rights: '17-63' }
        //     },
        //     {
        //       path: 'tenants_master_list',
        //       name: 'Tenants Master List',
        //       component: tenants_master_list,
        //       meta: { requiresAuth: true, rights: '17-63' }
        //     },
        //     {
        //       path: 'contracts_master_list',
        //       name: 'Contracts Master List',
        //       component: contracts_master_list,
        //       meta: { requiresAuth: true, rights: '17-63' }
        //     },
        //     {
        //       path: 'billing_forecast',
        //       name: 'Billing Forecast',
        //       component: billing_forecast,
        //       meta: { requiresAuth: true, rights: '17-63' }
        //     },
        //     {
        //       path: 'rental_and_charges',
        //       name: 'Rental Rates and Charges',
        //       component: rental_and_charges,
        //       meta: { requiresAuth: true, rights: '17-63' }
        //     },
        //     {
        //       path: 'expiring_contracts',
        //       name: 'Expiring Contracts',
        //       component: expiring_contracts,
        //       meta: { requiresAuth: true}
        //     },
        //     {
        //       path: 'new_contracts',
        //       name: 'New Contracts',
        //       component: new_contracts,
        //       meta: { requiresAuth: true}
        //     },
        //     {
        //       path: 'collection_report',
        //       name: 'Collection Report',
        //       component: collectionreport,
        //       meta: { requiresAuth: true}
        //     }
        //   ]
        // },
        // {
        //   path: 'transactions',
        //   name: 'Transactions',
        //   component: {
        //     render (c) { return c('router-view') }
        //   },
        //   children: [
        //     {
        //       path: 'tenants',
        //       name: 'Tenants',
        //       component: tenants,
        //       meta: {requiresAuth: true, rights: '1-1'},
        //     },
        //     {
        //       path: 'contracts',
        //       name: 'Contracts',
        //       component: contracts,
        //       meta: {requiresAuth: true, rights: '13-46'}
        //     },
        //     {
        //       path: 'billing',
        //       name: 'Billing',
        //       component: billing,
        //       meta: {requiresAuth: true, rights: '14-50'}
        //     },
        //     {
        //       path: 'payment',
        //       name: 'Payment',
        //       component: payment,
        //       meta: {requiresAuth: true, rights: '15-55'}
        //     },
        //     {
        //       path: 'adjustment',
        //       name: 'Adjustment',
        //       component: adjustment,
        //       meta: {requiresAuth: true, rights: '16-59'}
        //     },
        //     {
        //       path: 'chargeslip',
        //       name: 'Charge Slip',
        //       component: chargeslip,
        //       meta: {requiresAuth: true, rights: '20-74'}
        //     }
        //   ]
        // },
        // {
        //   path: 'accounting',
        //   name: 'Accounting',
        //   component: {
        //     render (c) { return c('router-view') }
        //   },
        //   children: [
        //     {
        //       path: 'ar_billing',
        //       name: 'AR Billing',
        //       component: ar_billing,
        //       meta: { requiresAuth: true, rights: '18-64'}
        //     },
        //     {
        //       path: 'ar_payment',
        //       name: 'AR Payment',
        //       component: ar_payment,
        //       meta: { requiresAuth: true, rights: '19-66'}
        //     }
        //   ]
        // },
        // {
        //   path: 'components',
        //   redirect: '/components/buttons',
        //   name: 'Components',
        //   component: {
        //     render (c) { return c('router-view') }
        //   },
        //   children: [
        //     {
        //       path: 'buttons',
        //       name: 'Buttons',
        //       component: Buttons
        //     },
        //     {
        //       path: 'social-buttons',
        //       name: 'Social Buttons',
        //       component: SocialButtons
        //     },
        //     {
        //       path: 'cards',
        //       name: 'Cards',
        //       component: Cards
        //     },
        //     {
        //       path: 'forms',
        //       name: 'Forms',
        //       component: Forms
        //     },
        //     {
        //       path: 'modals',
        //       name: 'Modals',
        //       component: Modals
        //     },
        //     {
        //       path: 'switches',
        //       name: 'Switches',
        //       component: Switches
        //     },
        //     {
        //       path: 'tables',
        //       name: 'Tables',
        //       component: Tables
        //     }
        //   ]
        // },
        // {
        //   path: 'icons',
        //   redirect: '/icons/font-awesome',
        //   name: 'Icons',
        //   component: {
        //     render (c) { return c('router-view') }
        //   },
        //   children: [
        //     {
        //       path: 'font-awesome',
        //       name: 'Font Awesome',
        //       component: FontAwesome
        //     },
        //     {
        //       path: 'simple-line-icons',
        //       name: 'Simple Line Icons',
        //       component: SimpleLineIcons
        //     }
        //   ]
        // }
      ]
    },
    // {
    //   path: '/pages',
    //   redirect: '/pages/404',
    //   name: 'Pages',
    //   component: {
    //     render (c) { return c('router-view') }
    //   },
    //   children: [
    //     {
    //       path: '404',
    //       name: 'Page404',
    //       component: Page404
    //     },
    //     {
    //       path: '500',
    //       name: 'Page500',
    //       component: Page500
    //     },
    //     {
    //       path: 'login',
    //       name: 'Login',
    //       component: Login
    //     },
    //     {
    //       path: 'register',
    //       name: 'Register',
    //       component: Register
    //     }
    //   ]
    // },
    {
      path: '/register',
      name: 'Register',
      component: Register
    },
    {
      path: '/login',
      name: 'Login',
      component: Login
    },
    {
      path: '/logout',
      name: 'Logout',
      component: Logout
    },
    {
      path: '*',
      name:'404', 
      component: Page404
    },
  ]
})
export default router
router.beforeEach((to, from, next) => {

  //check if user has rights on this route
  if(to.matched.some(route => route.meta.rights)){
    var right = false
    var row = store.state.rights.filter(right => 
      right.right_code == to.meta.rights
    )

    if(row.length > 0){
      right = true
    }

    if(!right){
      next({name: from.name})
      return
    }
  }

  // check if the route requires authentication and user is not logged in
  if (to.matched.some(route => route.meta.requiresAuth) && !store.state.isLoggedIn) {
    // redirect to login page
    next({ name: 'Login' })
    return
  }

// if logged in redirect to dashboard
  if(to.path === '/login' && store.state.isLoggedIn) {
      next({name: from.name})
      return
  }

next()
})
