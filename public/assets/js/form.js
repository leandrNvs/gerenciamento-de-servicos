const createForm = document.querySelector('form.create-form');
const updateForm = document.querySelector('form.update-form');

createForm?.phone.addEventListener('keyup', function(ev) {
  if (this.value.length === 11) {
    this.value = this.value.replace(/([\d]{2})([\d]{5})([\d]{4})/, '($1) $2-$3');
  }
})

createForm?.phone.addEventListener('keydown', function(ev) {
  if ((ev.key.match(/[^\d]/) || this.value.length > 11) && ev.key.toLowerCase() !== 'backspace') {
    ev.preventDefault();
  }
})

createForm?.cpf.addEventListener('keyup', function(ev) {
  if (this.value.length === 11) {
    this.value = this.value.replace(/([\d]{3})([\d]{3})([\d]{3})([\d]{2})/, '$1.$2.$3-$4');
  }
})

createForm?.cpf.addEventListener('keydown', function(ev) {
  if ((ev.key.match(/[^\d]/) || this.value.length > 11) && ev.key.toLowerCase() !== 'backspace') {
    ev.preventDefault();
  }
})

updateForm?.phone.addEventListener('keyup', function(ev) {
  if (this.value.length === 11) {
    this.value = this.value.replace(/([\d]{2})([\d]{5})([\d]{4})/, '($1) $2-$3');
  }
})

updateForm?.phone.addEventListener('keydown', function(ev) {
  if ((ev.key.match(/[^\d]/) || this.value.length > 11) && ev.key.toLowerCase() !== 'backspace') {
    ev.preventDefault();
  }
})

updateForm?.cpf.addEventListener('keyup', function(ev) {
  if (this.value.length === 11) {
    this.value = this.value.replace(/([\d]{3})([\d]{3})([\d]{3})([\d]{2})/, '$1.$2.$3-$4');
  }
})

updateForm?.cpf.addEventListener('keydown', function(ev) {
  if ((ev.key.match(/[^\d]/) || this.value.length > 11) && ev.key.toLowerCase() !== 'backspace') {
    ev.preventDefault();
  }
})

const sectionDeleteform = document.querySelector('section.section-delete');
const deleteForm = document.querySelector('form.delete-form');
const label = deleteForm.querySelector('b');

function confirmPartDelete(ev, el) {
  sectionDeleteform.classList.add('active');

  deleteForm.action = el.dataset.delete;
  deleteForm.id.value = el.dataset.id;
  deleteForm.querySelector('h2').textContent = "Confirme a exclusão da peça";
  deleteForm.querySelector('b').textContent = el.children[3].textContent;
}

function confirmInfoDelete(ev, el) {
  sectionDeleteform.classList.add('active');

  deleteForm.action = el.dataset.delete;
  deleteForm.id.value = el.dataset.id;
  deleteForm.querySelector('h2').textContent = "Confirme a exclusão de serviço";
  deleteForm.querySelector('b').textContent = el.children[0].textContent;
}

const serviceForm = document.querySelector('form.form-serviceinfo');
const partForm = document.querySelector('form.form-part');

const mutator = (field, value) => {
  const mutate = {
    'part_date_purchase': (value) => value.replace(/([\d]{4})\-([\d]{2})\-([\d]{2})/, '$3/$2/$1'),
    'part_price': (value) => value.replace('.', ','),
    'service_price': (value) => value.replace('.', ','),
    'service_descount': (value) => value === null? 0 : value 
  };

  if (!mutate.hasOwnProperty(field)) return value;

  return mutate[field](value)
}

function updatePart(ev, el) {
  const data = JSON.parse(el.dataset.data);

  delete (data.serviceid);
  delete (data.id);

  const keys = Object.keys(data);

  partForm.action = el.dataset.update;

  for (let i of keys) {
    partForm[i.replace('part_', '')].setAttribute('placeholder', mutator(i, data[i]));
  }

  partForm.querySelector('div.form-buttons').children[0].textContent = 'Salvar alterações';

  const div = createInput(el.dataset.id)

  partForm.appendChild(div);
}

function updateInfo(ev, el) {
  const data = JSON.parse(el.dataset.data);

  delete (data.serviceid);
  delete (data.id);

  const keys = Object.keys(data);

  serviceForm.action = el.dataset.update;

  for (let i of keys) {
    serviceForm[i.replace('service_', '')].setAttribute('placeholder', mutator(i, data[i]));
  }

  serviceForm.querySelector('div.form-buttons').children[0].textContent = 'Salvar alterações';

  const div = createInput(el.dataset.id)

  serviceForm.appendChild(div);
}

function createInput(id) {
  const idInput = document.createElement('input');
  idInput.setAttribute('type', 'hidden');
  idInput.setAttribute('name', 'id');
  idInput.setAttribute('value', id);

  const httpInput = document.createElement('input');
  httpInput.setAttribute('type', 'hidden');
  httpInput.setAttribute('name', '_method');
  httpInput.setAttribute('value', 'put');

  const div = document.createElement('div');
  div.setAttribute('style', 'display: none;');

  div.appendChild(idInput);
  div.appendChild(httpInput);

  return div;
}
