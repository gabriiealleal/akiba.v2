import { useParams } from 'react-router-dom';
import { usePost } from '@/services/posts/queries';
import ReactQuill from 'react-quill';
import 'react-quill/dist/quill.snow.css';
import EscrevaSuaMateriaLoading from '@/interfaces/private/placeholders/materias/EscrevaSuaMateriaLoading';

const EscrevaSuaMateria = () => {
    const { slug } = useParams();
    const { data: getPost, isLoading } = usePost(slug ?? "");
    const postagem = getPost?.publicação;

    if(slug){
        if(isLoading){
            return <EscrevaSuaMateriaLoading />
        }
    }

    const modules = {
        toolbar: [
            ['bold', 'italic', 'underline', 'strike'],       
            ['blockquote', 'code-block'],
            ['link', 'image', 'video'],
            [{ 'list': 'ordered'}, { 'list': 'bullet' }, { 'list': 'check' }],
            [{ 'script': 'sub'}, { 'script': 'super' }],      // superscript/subscript
            [{ 'indent': '-1'}, { 'indent': '+1' }],          // outdent/indent
            [{ 'align': [] }],
            [{ 'direction': 'rtl' }],                         // text direction
          
            [{ 'size': ['small', false, 'large', 'huge'] }],  // custom dropdown
            [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
          
            [{ 'color': [] }, { 'background': [] }],          // dropdown with defaults from theme
                    
        ]
    };

    return (
        <div className="mb-6">
            <label htmlFor="materia" className="font-averta font-extrabold text-laranja text-lg uppercase italic block">Escreva sua matéria</label>
            <ReactQuill modules={modules} className='h-96 bg-aurora overflow-hidden rounded-md font-averta mb-6' value={postagem?.content} />
        </div>
    );
}

export default EscrevaSuaMateria;