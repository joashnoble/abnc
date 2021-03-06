export default {
  items: [
    {
      name: 'Dashboard',
      url: '/dashboard',
      icon: 'icon-speedometer'
    },
    {
      name: 'Service Management',
      url: '/services',
      icon: 'icon-list'
    },  
    {
      name: 'Clients Management',
      url: '/clients',
      icon: 'icon-people'
    }, 
    {
      name: 'References',
      url: '/references',
      icon: 'icon-book-open',
      rights: [1,2,3,4,5],
      children:[
        {
          name: 'Departments',
          url: '/references/departments',
          rights: '1-1',
          icon: 'icon-folder'
        },     
        {
          name: 'Industries',
          url: '/references/industries',
          rights: '2-5',
          icon: 'icon-folder'
        },                
        {
          name: 'Service Categories',
          url: '/references/categories',
          rights: '3-9',
          icon: 'icon-folder'
        },
        {
          name: 'Service Type',
          url: '/references/ServiceType',
          rights: '4-13',
          icon: 'icon-folder'
        },
        {
          name: 'Service Group Type',
          url: '/references/ServiceGroupType',
          rights: '4-13',
          icon: 'icon-folder'
        }              
      ]
    },
    {
      name: 'Content Management',
      url: '/cms',
      icon: 'icon-wrench',
      rights: [6,7,8,9,10,11,12],
      children:[
        {
          name: 'News and Publication',
          url: '/cms/newspublication',
          rights: '6-21',
          icon: 'icon-list'
        },
        {
          name: 'Seminars',
          url: '/cms/seminars',
          rights: '7-25',
          icon: 'icon-list'
        },    
        {
          name: 'CSR',
          url: '/cms/csr',
          rights: '8-29',
          icon: 'icon-list'
        }, 
        {
          name: 'Careers',
          url: '/cms/careers',
          rights: '9-33',
          icon: 'icon-list'
        },    
        // {
        //   name: 'Gallery',
        //   url: '/cms/gallery',
        //   rights: '10-37',
        //   icon: 'icon-list'
        // },           
        {
          name: 'Teams',
          url: '/cms/teams',
          rights: '11-41',
          icon: 'icon-list'
        },    
        {
          name: 'Carousel',
          url: '/cms/carousels',
          rights: '12-45',
          icon: 'icon-list'
        },                                        
      ]
    },
    {
      name: 'Archive Management',
      url: '/archives',
      icon: 'fa fa-archive',
      rights: [6,7,8,9,10,11,12],
      children:[
        {
          name: 'Services',
          url: '/archives/services',
          rights: '6-21',
          icon: 'icon-list'
        },
        {
          name: 'News And Publications',
          url: '/archives/NewsPublication',
          rights: '6-21',
          icon: 'icon-list'
        },                          
      ]

    },
    // {
    //   name: 'Transactions',
    //   url: '/transactions',
    //   icon: 'icon-note',
    //   rights: [1,13,14,15,16],
    //   children:[
    //     {
    //       name: 'Tenants',
    //       url: '/transactions/tenants',
    //       rights: '1-1',
    //       icon: 'icon-user-follow'
    //     },
    //     {
    //       name: 'Contracts',
    //       url: '/transactions/contracts',
    //       rights: '13-46',
    //       icon: 'icon-envelope-letter'
    //     },
    //     {
    //       name: 'Billing',
    //       url: '/transactions/billing',
    //       rights: '14-50',
    //       icon: 'icon-briefcase'
    //     },
    //     {
    //       name: 'Payment',
    //       url: '/transactions/payment',
    //       rights: '15-55',
    //       icon: 'icon-wallet'
    //     },
    //     {
    //       name: 'Adjustment',
    //       url: '/transactions/adjustment',
    //       rights: '16-59',
    //       icon: 'icon-cursor-move'
    //     },
    //     {
    //       name: 'Charge Slip',
    //       url: '/transactions/chargeslip',
    //       rights: '20-73',
    //       icon: 'icon-cursor-move'
    //     }
    //   ]
    // },
    // {
    //   name: 'Accounting',
    //   url: '/accounting',
    //   icon: 'icon-calculator',
    //   rights: [18,19],
    //   children:[
    //     {
    //       name: 'AR Billing',
    //       url: '/accounting/ar_billing',
    //       rights: '18-64',
    //       icon: 'icon-briefcase'
    //     },
    //     {
    //       name: 'AR Payment',
    //       url: '/accounting/ar_payment',
    //       rights: '19-66',
    //       icon: 'icon-wallet'
    //     },
    //   ]
    // },
    // {
    //   name: 'Reports',
    //   url: '/reports',
    //   icon: 'icon-doc',
    //   rights: [17],
    //   children:[
    //     {
    //       name: 'Tenant Per Sqm Rate',
    //       url: '/reports/tenant_per_sqm_rate',
    //       icon: 'icon-layers'
    //     },
    //     {
    //       name: 'Tenants Master List',
    //       url: '/reports/tenants_master_list',
    //       icon: 'icon-layers'
    //     },
    //     {
    //       name: 'Contracts Master List',
    //       url: '/reports/contracts_master_list',
    //       icon: 'icon-layers'
    //     },
    //     {
    //       name: 'Billing Forecast',
    //       url: '/reports/billing_forecast',
    //       icon: 'icon-layers'
    //     },
    //     {
    //       name: 'Rental Rates and Charges',
    //       url: '/reports/rental_and_charges',
    //       icon: 'icon-layers'
    //     },
    //     {
    //       name: 'Collection Report',
    //       url: '/reports/collection_report',
    //       icon: 'icon-layers'
    //     },
    //   ]
    // },
    {
      name: 'Settings',
      url: '/accounts',
      icon: 'icon-settings',
      rights: [13,14,15],
      children:[
        {
          name: 'Users',
          url: '/accounts/users',
          rights: '13-49',
          icon: 'icon-user'
        },
        {
          name: 'User Group',
          url: '/accounts/user_groups',
          rights: '14-53',
          icon: 'icon-people'
        },
        {
          name: 'Company Settings',
          url: '/accounts/company_settings',
          rights: '15-57',
          icon: 'icon-settings'
        }
      ]
    },
    // {
    //   name: 'Components',
    //   url: '/components/buttons',
    //   icon: 'icon-puzzle',
    //   children: [
    //     {
    //       name: 'Buttons',
    //       url: '/components/buttons',
    //       icon: 'icon-puzzle'
    //     },
    //     {
    //       name: 'Social Buttons',
    //       url: '/components/social-buttons',
    //       icon: 'icon-puzzle'
    //     },
    //     {
    //       name: 'Cards',
    //       url: '/components/cards',
    //       icon: 'icon-puzzle'
    //     },
    //     {
    //       name: 'Forms',
    //       url: '/components/forms',
    //       icon: 'icon-puzzle'
    //     },
    //     {
    //       name: 'Modals',
    //       url: '/components/modals',
    //       icon: 'icon-puzzle'
    //     },
    //     {
    //       name: 'Switches',
    //       url: '/components/switches',
    //       icon: 'icon-puzzle'
    //     },
    //     {
    //       name: 'Tables',
    //       url: '/components/tables',
    //       icon: 'icon-puzzle'
    //     }
    //   ]
    // },
    // {
    //   name: 'Icons',
    //   url: '/icons',
    //   icon: 'icon-star',
    //   children: [
    //     {
    //       name: 'Font Awesome',
    //       url: '/icons/font-awesome',
    //       icon: 'icon-star'
    //     },
    //     {
    //       name: 'Simple Line Icons',
    //       url: '/icons/simple-line-icons',
    //       icon: 'icon-star'
    //     }
    //   ]
    // },
    // {
    //   name: 'Widgets',
    //   url: '/widgets',
    //   icon: 'icon-calculator',
    //   badge: {
    //     variant: 'danger',
    //     text: 'NEW'
    //   }
    // },
    // {
    //   name: 'Charts',
    //   url: '/charts',
    //   icon: 'icon-pie-chart'
    // },
    // {
    //   divider: true
    // },
    // {
    //   title: true,
    //   name: 'Extras'
    // },
    // {
    //   name: 'Pages',
    //   url: '/pages',
    //   icon: 'icon-star',
    //   children: [
    //     {
    //       name: 'Login',
    //       url: '/pages/login',
    //       icon: 'icon-star'
    //     },
    //     {
    //       name: 'Register',
    //       url: '/pages/register',
    //       icon: 'icon-star'
    //     },
    //     {
    //       name: 'Error 404',
    //       url: '/pages/404',
    //       icon: 'icon-star'
    //     },
    //     {
    //       name: 'Error 500',
    //       url: '/pages/500',
    //       icon: 'icon-star'
    //     }
    //   ]
    // }
  ],
}
